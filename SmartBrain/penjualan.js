const dashboard = window.location.origin + "/Kasir/Dashboard/";
const base_url = window.location.origin + "/Kasir/Penjualan/";
let table = null;
let table_barang = null;
let id_nota = null;
let xBegin = moment().subtract(29, "days");
let xEnd = moment();
let data_barang = [];

function req_ajx(url, params) {
	$.ajax({
		url: base_url + url,
		type: "POST",
		data: params,
		dataType: "json",
		success: function (res) {
			if (res.status == 1) {
				toastr.success(res.pesan);
				$(".modal").modal("hide");
				table.ajax.reload(null, false);
			} else {
				toastr.error(res.pesan);
			}
		},
	});
}

function cb(xBegin, xEnd) {
	let tgl1 = xBegin.format("YYYY-MM-DD");
	let tgl2 = xEnd.format("YYYY-MM-DD");
	$("#xBegin").val(tgl1);
	$("#xEnd").val(tgl2);
	$("#periode").html(tgl1 + " to " + tgl2);
	table.ajax.reload(null, false);
}

function hitung_total_harga() {
	let tJml = (tTotal_harga = 0);
	$("#tbl_keranjang tbody tr").each(function () {
		let jml = $(this).find("td:eq(2)").text();
		let total_harga = $(this).find("td:eq(3)").text();
		tJml += parseInt(jml, 10);
		tTotal_harga += parseInt(total_harga, 10);
	});

	$("#tbl_keranjang tfoot th:eq(1)").html(tTotal_harga);
	if (tTotal_harga > 0) {
		$(".tr-input-bayar-user").show();
	} else {
		$(".tr-input-bayar-user").hide();
	}
}

$(document).ready(function () {
	$("#reportrange").daterangepicker(
		{
			startDate: xBegin,
			endDate: xEnd,
			ranges: {
				Today: [moment(), moment()],
				Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"Last 7 Days": [moment().subtract(6, "days"), moment()],
				"Last 30 Days": [moment().subtract(29, "days"), moment()],
				"This Month": [moment().startOf("month"), moment().endOf("month")],
				"Last Month": [
					moment().subtract(1, "month").startOf("month"),
					moment().subtract(1, "month").endOf("month"),
				],
			},
		},
		cb
	);

	table = $("#penjualan").DataTable({
		pageLength: 10,
		lengthChange: false,
		info: false,
		autoWidth: true,
		responsive: true,
		serverSide: true,
		processing: true,
		dom:
			"<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
		buttons: [
			{
				extend: "pageLength",
				text: "Tampilkan",
				className: "btn-sm btn-info",
			},
			{
				extend: "pdf",
				className: "btn-sm btn-danger",
				text: '<i class="fa fa-file-pdf"></i>&nbsp; PDF',
			},
		],
		ajax: {
			url: base_url + "show",
			type: "POST",
			data: function (d) {
				d.xBegin = $("#xBegin").val();
				d.xEnd = $("#xEnd").val();
			},
		},
		columns: [
			{
				data: "tgl_keluar",
				className: "text-center",
			},
			{
				data: "id_nota",
				className: "text-center",
			},
			{
				data: "nama_pembeli",
				className: "text-center",
			},
			{
				data: "total",
				className: "text-right",
			},
			{
				data: "id_nota",
				className: "text-center",
				render: function (data, type, row, meta) {
					return (
						`<a href="#preview" class="badge badge-secondary btn-detail" data-toggle="modal" data-id="` +
						row.id_nota +
						`">Detail</a>
                        <a href="#modal-edit-nota" class="badge badge-info btn-edit" data-toggle="modal" data-id="` +
						row.id_nota +
						`">Edit</a>
                        <a href="#" class="badge badge-danger btn-delete" data-id="` +
						row.id_nota +
						`" data-nama="` +
						row.tgl_keluar +
						`">Hapus</a>`
					);
				},
			},
		],
	});

	table_barang = $("#barang").DataTable({
		lengthChange: false,
		info: false,
		autoWidth: true,
		responsive: true,
		pageLength: 10,
		serverSide: true,
		processing: true,
		ajax: {
			url: dashboard + "stok",
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

	cb(xBegin, xEnd);
});

$(document).on("click", ".btn-detail", function () {
	$("#data_penjualan").empty();

	$.ajax({
		url: base_url + "detail",
		type: "POST",
		data: {
			id_nota: $(this).data("id"),
		},
		dataType: "json",
		success: function (res) {
			$("#btn_print_nota").removeAttr();
			$("#btn_print_faktur").removeAttr();
			$("#btn_print_nota").attr(
				"href",
				base_url + "print/nota/" + res.nota.id_nota
			);
			$("#btn_print_faktur").attr(
				"href",
				base_url + "print/faktur/" + res.nota.id_nota
			);

			$(".h_id_nota").html(
				res.nota.tgl_keluar +
					" : No.Nota " +
					res.nota.id_nota +
					" <br> Pembeli : " +
					res.nota.nama_pembeli
			);

			$("#data_penjualan").html(res.item);
		},
	});
});

$(document).on("click", ".btn-edit", function () {
	table_barang.ajax.reload(null, false);
	data_barang = [];
	id_nota = $(this).data("id");

	$.ajax({
		url: base_url + "detail",
		type: "POST",
		data: {
			id_nota: $(this).data("id"),
		},
		dataType: "json",
		success: function (res) {
			$(".h_id_nota").html(
				res.nota.tgl_keluar + " : No.Nota " + res.nota.id_nota
			);
			$("#tbl_keranjang tbody").html(res.item);

			$("#tbl_keranjang tbody tr").each(function () {
				let harga = $(this).find("td:eq(2)").text();
				let jml = $(this).find("td:eq(3)").text();
				let total_harga = $(this).find("td:eq(4)").text();
				$(this).find("td:first").remove();
				$(this)
					.find("td:eq(1)")
					.removeClass("text-center")
					.addClass("text-right harga_jual");
				$(this).find("td:eq(2)").addClass("text-center iJml");
				$(this).find("td:eq(2)").attr("contenteditable", "true");
				$(this)
					.find("td:eq(2)")
					.attr("onkeypress", "return isNumberKey(event)");
				$(this)
					.find("td:eq(3)")
					.removeClass("text-center")
					.addClass("text-right");
				$(this).find("td:last").after(`<td class="text-center">
                <a href="#" class='btn-danger btn-sm btn-batal'>Batal</a>
                </td>`);
				$(this).find("td:eq(1)").html(harga.replace(/,/g, ""));
				$(this).find("td:eq(2)").html(jml.replace(/,/g, ""));
				$(this).find("td:eq(3)").html(total_harga.replace(/,/g, ""));

				let sID = $(this).data("id");
				data_barang.push(sID);
			});

			$("#tbl_keranjang tfoot th:eq(1)").html(res.nota.total);
			$("#bayar").val(res.nota.bayar);
			$("#kembali").val(res.nota.kembalian);
			$("#nama_pembeli").val(res.nota.nama_pembeli);
		},
	});
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
		url: base_url + "update",
		type: "POST",
		data: {
			id_nota: id_nota,
			arr_barang: arr_barang,
			total: total,
			bayar: bayar,
			kembalian: $("#kembali").val(),
			nama_pembeli: $("#nama_pembeli").val(),
		},
		dataType: "json",
		success: function (res) {
			if (res.status == 1) {
				table.ajax.reload(null, false);
				toastr.success("Berhasil Menyimpan Nota");
				$("#modal-edit-nota").modal("hide");
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

$(document).on("click", ".btn-pick", function () {
	let id = $(this).data("id");
	let tr = $(this).parent().parent();
	let nama_barang = tr.find("td:eq(0)").text();
	let harga = tr.find("td:eq(1)").text();
	let stok = tr.find("td:eq(2)").text();

	if (!data_barang.includes(id)) {
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
                <td class="text-center iJml" contenteditable="true" 
                    onkeypress="return isNumberKey(event)" data-id="` +
				id +
				`" data-stok="` +
				stok +
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
	} else {
		toastr.error("Data Barang Sudah Ada di Nota");
	}
	tr.hide();
});

$(document).on("keyup", ".iJml", function () {
	let tr = $(this).closest("tr");
	let id = tr.data("id");

	let jml = $(this).text();
	let harga = tr.find("td:eq(1)").text();
	let stok = tr.find("td:eq(2)").data("stok");

	harga = parseInt(harga.replace(/,/g, ""), 10);
	jml = parseInt(jml.replace(/,/g, ""), 10);
	stok = parseInt(stok, 10);

	const total = tr.find("td:eq(3)");
	if (jml > stok) {
		total.text("0");
	} else {
		let hasil = harga * jml;
		if (hasil) {
			total.text(hasil);
		} else {
			total.text("0");
		}
	}

	hitung_total_harga();
});

$(document).on("input", "#bayar", function () {
	$(this).removeClass("border border-danger");
	$("#txt_kembali").val(null);
	$("#kembali").val(null);

	let total = parseInt($("#tbl_keranjang tfoot th:eq(1)").text(), 10);
	let bayar = parseInt($(this).val(), 10);
	let kembali = bayar - total;
	if (kembali >= 0) {
		$("#txt_kembali").val(kembali);
		$("#kembali").val(kembali);
	} else {
		$("#txt_kembali").val(kembali);
		$("#kembali").val(kembali);
	}

	if (bayar > 0) {
		$(".tr-btn-save-nota").show();
	} else {
		$(".tr-btn-save-nota").hide();
	}
});

$(document).on("click", ".btn-batal", function () {
	const tr = $(this).closest("tr");
	let id = tr.data("id");
	let stok = tr.find(".iJml").data("stok");
	data_barang = data_barang.filter((item) => item !== id);

	$("#barang tbody tr").each(function () {
		let data_id = $(this).find("td:last a").data("id");
		if (data_id == id) {
			$(this).find("td:eq(2)").html(stok);
			$(this).show();
		}
	});

	tr.remove();

	hitung_total_harga();
});

$(document).on("click", ".btn-delete", function () {
	if (confirm("Apakah anda yakin akan menghapus nota ini ? ")) {
		req_ajx("delete", {
			id_nota: $(this).data("id"),
		});
	}
});
