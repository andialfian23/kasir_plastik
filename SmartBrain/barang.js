const date_now = moment().format("YYYY-MM-DD");
const base_url = window.location.origin + "/Kasir/";
let table = null;
let id_barang = null;

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

$(document).ready(function () {
	table = $("#barang").DataTable({
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
			"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
			url: base_url + "Barang/show",
			type: "POST",
		},
		columns: [
			{
				data: "nama_barang",
			},
			{
				data: "harga_barang",
				className: "text-center",
			},
			{
				data: "harga_jual",
				className: "text-center",
			},
			{
				data: "pemasukan",
				className: "text-center",
			},
			{
				data: "pengeluaran",
				className: "text-center",
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
						`<a href="#modalBarang" class="badge badge-success btn-add-stock" data-toggle="modal" data-id="` +
						row.id_barang +
						`">Tambah Stok</a>`
					);
				},
			},
			{
				data: "id_barang",
				className: "text-center",
				render: function (data, type, row, meta) {
					return (
						`<a href="#preview" class="badge badge-secondary btn-detail" data-toggle="modal" data-id="` +
						row.id_barang +
						`">Detail</a>
                        <a href="#modalBarang" class="badge badge-info btn-edit" data-toggle="modal" data-id="` +
						row.id_barang +
						`">Edit</a>
                        <a href="#" class="badge badge-danger btn-delete" data-id="` +
						row.id_barang +
						`" data-nama="` +
						row.nama_barang +
						`">Hapus</a>`
					);
				},
			},
		],
	});
});

$(document).on("click", ".btn-add", function () {
	$("#modalBarang .modal-title").html("Form Tambah Barang");
	$("#modalBarang small").html("");
	$("#modalBarang input").val(null);
	$("#modalBarang input").removeClass("border-danger");
	$("#tgl_masuk").val(date_now);
	$("#tgl_masuk").removeAttr("disabled");
	$("#nama_barang").removeAttr("disabled");
	$("#btn-save,.input_tgl,.input_stock").show();
	$("#btn-save-stock,#btn-save-edit").hide();
});

$(document).on("click", "#btn-save", function () {
	$("#modalBarang small").html("");
	$("#modalBarang input").removeClass("border-danger");

	if ($("#tgl_masuk").val() == "") {
		$("#tgl_masuk").addClass("border border-danger");
		$("#notif_tgl_masuk").html("Tanggal tidak Boleh Kosong !!");
		return false;
	}

	if ($("#nama_barang").val() == "") {
		$("#nama_barang").addClass("border border-danger");
		$("#notif_nama_barang").html("Nama Barang tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_beli").val() == "") {
		$("#harga_beli").addClass("border border-danger");
		$("#notif_harga_beli").html("Harga Beli tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_jual").val() == "") {
		$("#harga_jual").addClass("border border-danger");
		$("#notif_harga_jual").html("Harga Jual tidak Boleh Kosong !!");
		return false;
	}

	if ($("#jml_stok").val() == "") {
		$("#jml_stok").addClass("border border-danger");
		$("#notif_jml_stok").html("Jumlah Stok tidak Boleh Kosong !!");
		return false;
	}

	let data_input = {
		nama_barang: $("#nama_barang").val(),
		harga_beli: $("#harga_beli").val(),
		harga_jual: $("#harga_jual").val(),
		tgl_masuk: $("#tgl_masuk").val(),
		jml_stok: $("#jml_stok").val(),
	};

	req_ajx("Barang/insert", data_input);
});

$(document).on("click", ".btn-add-stock", function () {
	id_barang = $(this).data("id");
	$("#modalBarang .modal-title").html("Form Tambah Stok Barang");
	$("#modalBarang input").val(null);
	$("#tgl_masuk").val(date_now);
	$("#btn-save,#btn-save-edit").hide();
	$("#btn-save-stock,.input_tgl,.input_stock").show();

	$.ajax({
		url: base_url + "Barang/detail",
		type: "POST",
		data: {
			id_barang: id_barang,
		},
		dataType: "json",
		success: function (res) {
			$("#nama_barang").val(res.data.nama_barang).attr("disabled", "disabled");
			$("#harga_beli").val(res.data.harga_barang);
			$("#harga_jual").val(res.data.harga_jual);
		},
	});
});

$(document).on("click", "#btn-save-stock", function () {
	$("#addStock small").html("");
	$("#addStock input").removeClass("border-danger");

	if ($("#tgl_masuk").val() == "") {
		$("#tgl_masuk").addClass("border border-danger");
		$("#notif_tgl_masuk").html("Tanggal tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_beli").val() == "") {
		$("#harga_beli").addClass("border border-danger");
		$("#notif_harga_beli").html("Harga Beli tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_jual").val() == "") {
		$("#harga_jual").addClass("border border-danger");
		$("#notif_harga_jual").html("Harga Jual tidak Boleh Kosong !!");
		return false;
	}

	if ($("#jml_stok").val() == "") {
		$("#jml_stok").addClass("border border-danger");
		$("#notif_jml_stok").html("Jumlah Stok tidak Boleh Kosong !!");
		return false;
	}

	let data_input = {
		id_barang: id_barang,
		tgl_masuk: $("#tgl_masuk").val(),
		harga_beli: $("#harga_beli").val(),
		harga_jual: $("#harga_jual").val(),
		jml_stok: $("#jml_stok").val(),
	};

	req_ajx("Pemasukan/insert", data_input);
});

$(document).on("click", ".btn-edit", function () {
	id_barang = $(this).data("id");
	$("#modalBarang .modal-title").html("Form Edit Barang");
	$("#modalBarang small").html("");
	$("#modalBarang input").val(null);
	$("#modalBarang input").removeClass("border-danger");
	$("#btn-save,#btn-save-stock,.input_tgl,.input_stock").hide();
	$("#btn-save-edit").show();

	$.ajax({
		url: base_url + "Barang/detail",
		type: "POST",
		data: {
			id_barang: id_barang,
		},
		dataType: "json",
		success: function (res) {
			$("#nama_barang").val(res.data.nama_barang);
			$("#harga_beli").val(res.data.harga_barang);
			$("#harga_jual").val(res.data.harga_jual);
		},
	});
});

$(document).on("click", "#btn-save-edit", function () {
	$("#modalBarang small").html("");
	$("#modalBarang input").removeClass("border-danger");

	if ($("#nama_barang").val() == "") {
		$("#nama_barang").addClass("border border-danger");
		$("#notif_nama_barang").html("Nama Barang tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_beli").val() == "") {
		$("#harga_beli").addClass("border border-danger");
		$("#notif_harga_beli").html("Harga Beli tidak Boleh Kosong !!");
		return false;
	}

	if ($("#harga_jual").val() == "") {
		$("#harga_jual").addClass("border border-danger");
		$("#notif_harga_jual").html("Harga Jual tidak Boleh Kosong !!");
		return false;
	}

	let data_update = {
		id_barang: id_barang,
		nama_barang: $("#nama_barang").val(),
		harga_beli: $("#harga_beli").val(),
		harga_jual: $("#harga_jual").val(),
	};

	req_ajx("Barang/update", data_update);
});

$(document).on("click", ".btn-delete", function () {
	let id_barang = $(this).data("id");
	let nama_barang = $(this).data("nama");

	if (confirm("Apakah anda yakin akan menghapus data " + nama_barang + " ?")) {
		let data_hapus = {
			id_barang: id_barang,
		};
		req_ajx("Barang/delete", data_hapus);
	}
});

$(document).on("click", ".btn-del-pm", function () {
	let id_pemasukan = $(this).data("id");

	if (confirm("Apakah anda yakin akan menghapus data pemasukan ini ?")) {
		let data_hapus = {
			id_pemasukan: id_pemasukan,
		};
		req_ajx("Pemasukan/delete", data_hapus);
	}
});

$(document).on("click", ".btn-detail", function () {
	$("#stok").empty();
	id_barang = $(this).data("id");
	$.ajax({
		url: base_url + "Pemasukan/show",
		type: "POST",
		data: {
			id_barang: id_barang,
		},
		dataType: "json",
		success: function (res) {
			$("#stok").removeAttr("style");
			if (res.total_row > 3) {
				$("#stok").attr("style", "height: 750px;");
			}

			$("#h_nama_barang").html(res.nama_barang);
			$("#stok").html(res.data);
		},
	});
});
