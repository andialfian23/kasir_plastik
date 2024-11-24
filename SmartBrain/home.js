const base_url = window.location.origin + "/Kasir/Dashboard/";
const base_url2 = window.location.origin + "/Kasir/Penjualan/";
let table = null;

function hitung_total_harga() {
	let tJml = (tTotal_harga = 0);
	$("#tbl_keranjang tbody tr").each(function () {
		let jml = $(this).find("td:eq(3)").text();
		let total_harga = $(this).find("td:eq(4)").text();
		tJml += parseInt(jml, 10);
		tTotal_harga += parseInt(total_harga, 10);
	});

	$("#tbl_keranjang tfoot th:eq(1)").html(tJml);
	$("#tbl_keranjang tfoot th:eq(2)").html(tTotal_harga);
	if (tTotal_harga > 0) {
		$(".tr-input-bayar-user").show();
	} else {
		$(".tr-input-bayar-user").hide();
	}
}

$(function () {
	$(".tr-input-bayar-user,.tr-btn-save-nota").hide();

	table = $("#barang").DataTable({
		lengthChange: false,
		info: false,
		autoWidth: true,
		responsive: true,
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: base_url + "stok",
			type: "POST",
		},
		columns: [
			{
				data: "nama_barang",
			},
			{
				data: "harga_jual",
				className: "text-right",
			},
			{
				data: "stok",
				className: "text-center",
			},
			{
				data: "id_barang",
				className: "text-center",
				render: function (data, type, row, meta) {
					return (
						`<a href="#" class="btn-info btn-sm btn-pick" data-id="` +
						row.id_barang +
						`">Tambah</a>`
					);
				},
			},
		],
	});
});

$(document).on("click", ".btn-pick", function () {
	let id = $(this).data("id");
	let tr = $(this).parent().parent();
	let nama_barang = tr.find("td:eq(0)").text();
	let harga = tr.find("td:eq(1)").text();
	let stok = tr.find("td:eq(2)").text();

	$("#tbl_keranjang tbody").append(
		`<tr data-id="` +
			id +
			`">
            <td>` +
			nama_barang +
			`</td>
            <td class="text-right harga_jual" data-id="` +
			id +
			`">` +
			harga +
			`</td>
            <td class="text-center stok" data-id="` +
			id +
			`">` +
			stok +
			`</td>
            <td class="text-center iJml" contenteditable="true" 
                onkeypress="return isNumberKey(event)" data-id="` +
			id +
			`">
            </td>
            <td class="text-right" data-id="` +
			id +
			`"></td>
            <td class="text-center">
                <a href="#" class='btn-danger btn-sm btn-batal' data-id="` +
			id +
			`">Batal</a>
            </td>
        </tr>`
	);

	tr.hide();
});

$(document).on("keyup", ".iJml", function () {
	let tr = $(this).closest("tr");
	let id = $(this).data("id");

	let jml = $(this).text();
	let harga = tr.find("td:eq(1)").text();
	let stok = tr.find("td:eq(2)").text();

	harga = parseInt(harga, 10);
	jml = parseInt(jml, 10);
	stok = parseInt(stok, 10);

	if (jml > stok) {
		tr.find("td:eq(4)").text("0");
	} else {
		let hasil = harga * jml;
		if (hasil) {
			tr.find("td:eq(4)").text(hasil);
		} else {
			tr.find("td:eq(4)").text("0");
		}
	}

	hitung_total_harga();
});

$(document).on("click", ".btn-batal", function () {
	let id = $(this).data("id");
	let tr = $(this).closest("tr");
	$("#barang tbody tr").each(function () {
		let data_id = $(this).find("td:last a").data("id");
		if (data_id == id) {
			$(this).show();
		}
	});
	tr.remove();

	hitung_total_harga();
});

$(document).on("input", "#bayar", function () {
	$(this).removeClass("border border-danger");
	$("#txt_kembali").val(null);
	$("#kembali").val(null);

	let total = parseInt($("#tbl_keranjang tfoot th:eq(2)").text(), 10);
	let bayar = parseInt($(this).val(), 10);
	let kembali = bayar - total;
	if (kembali >= 0) {
		$("#txt_kembali").val(kembali);
		$("#kembali").val(kembali);
	} else {
		// let kembali = total - bayar;
		$("#txt_kembali").val(kembali);
		$("#kembali").val(kembali);
	}

	if (bayar > 0) {
		$(".tr-btn-save-nota").show();
	} else {
		$(".tr-btn-save-nota").hide();
	}
});

$(document).on("click", "#btn-save-nota", function () {
	if ($("#bayar").val() == "") {
		$("#bayar").addClass("is-invalid");
		return false;
	} else {
		$("#bayar").removeClass("is-invalid");
	}

	if ($("#nama_pembeli").val() == "") {
		$("#nama_pembeli").addClass("is-invalid");
		return false;
	} else {
		$("#nama_pembeli").removeClass("is-invalid");
	}

	let arr_barang = [];
	$("#tbl_keranjang tbody tr").each(function (i) {
		arr_barang[i] = {
			id_barang: $(this).data("id"),
			harga: $(this).find(".harga_jual").text(),
			qty: $(this).find(".iJml").text(),
		};
	});

	let total = parseInt($("#tbl_keranjang tfoot th:eq(1)").text());
	let bayar = parseInt($("#bayar").val());
	if (bayar < total) {
		toastr.error("Input Bayar Lebih Kecil dari Total");
		$("#bayar").addClass("is-invalid");
		return false;
	} else {
		$("#bayar").removeClass("is-invalid");
	}

	$.ajax({
		url: base_url + "insert",
		type: "POST",
		data: {
			arr_barang: arr_barang,
			total: $("#tbl_keranjang tfoot th:eq(2)").text(),
			bayar: $("#bayar").val(),
			kembalian: $("#kembali").val(),
			nama_pembeli: $("#nama_pembeli").val(),
		},
		dataType: "json",
		success: function (res) {
			if (res.status == 1) {
				table.ajax.reload(null, false);
				$("#tbl_keranjang tbody").empty();
				$("#tbl_keranjang tfoot th:eq(1)").html("");
				$("#tbl_keranjang tfoot th:eq(2)").html("");
				$(".tr-input-bayar-user,.tr-btn-save-nota").hide();
				toastr.success("Berhasil Menyimpan Nota");
				$("#cekNota").modal("show");
				$("#btn_print_nota").attr(
					"href",
					base_url2 + "print/nota/" + res.id_nota
				);
				$("#btn_print_faktur").attr(
					"href",
					base_url2 + "print/faktur/" + res.id_nota
				);
			} else {
				toastr.error("Gagal Menyimpan Nota");
			}
		},
	});
});
