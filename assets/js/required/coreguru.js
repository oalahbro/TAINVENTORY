if (window.location.pathname.includes("guru")) {
	$(document).ready(function () {
		if (document.title.includes("Masukkan")) {
			showTmp();
		}
		if (document.title.includes("Request")) {
			dataTable();
		}
		if (document.title.includes("Unconfirmed")) {
			unTable();
		}
		if (document.title.includes("Semua")) {
			inventory();
		}
		if (document.title.includes("Profile")) {
			profile();
		}
		if (document.title.includes("Laporan")) {
			laporan();
		}
		if (document.title.includes("Search")) {
			search();
		}
	});

	$(".logout").click(function () {
		swal({
			title: "Anda yakin keluar?",
			text: "Setelah keluar anda akan diminta login untuk mengakses halaman ini",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				swal("Anda berhasil logout", {
					icon: "success",
					buttons: false,
				});
				setTimeout(function () {
					let p = window.location.origin;
					//ganti url location kalo udah deploy
					window.location = p + "/demo/login/logout";
				}, 1000);
			} else {
			}
		});
	});

	const MAX_WIDTH = 580;
	const MAX_HEIGHT = 854;
	const MIME_TYPE = "image/jpeg";
	const QUALITY = 0.4;
	const input = document.getElementById("img1");
	const inputMod = document.getElementById("imgInp");
	input.onchange = function (ev) {
		const file = ev.target.files[0]; // get the file
		const blobURL = URL.createObjectURL(file);
		const img = new Image();
		const bla = document.getElementById("bla");
		const [gambar] = input.files;
		if (gambar) {
			bla.src = URL.createObjectURL(file);
			bla.removeAttribute("hidden");
		}

		img.src = blobURL;
		img.onerror = function () {
			URL.revokeObjectURL(this.src);
			// Handle the failure properly
			swal("Gagal memuat gambar", {
				icon: "error",
				text: "File harus berupa gambar, jpg atau png!",
				timer: 2000,
				buttons: false,
			});
			console.log("Cannot load image");
			$("#bla").attr(
				"src",
				"https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png"
			);
		};
		img.onload = function () {
			URL.revokeObjectURL(this.src);
			const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
			const canvas = document.createElement("canvas");
			canvas.width = newWidth;
			canvas.height = newHeight;
			const ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0, newWidth, newHeight);
			canvas.toBlob((blob) => {}, MIME_TYPE, QUALITY);
			// document.getElementById("root").append(canvas);
			var dataURL = canvas.toDataURL();
			document.getElementById("putbase").value = dataURL;
		};
	};

	inputMod.onchange = function (ev) {
		const file = ev.target.files[0]; // get the file
		const blobURL = URL.createObjectURL(file);
		const img = new Image();
		const blah = document.getElementById("blah");
		const [gambar] = inputMod.files;
		if (gambar) {
			blah.src = URL.createObjectURL(file);
			blah.removeAttribute("hidden");
		}

		img.src = blobURL;
		img.onerror = function () {
			URL.revokeObjectURL(this.src);
			// Handle the failure properly
			swal("Gagal memuat gambar", {
				icon: "error",
				text: "File harus berupa gambar, jpg atau png!",
				timer: 2000,
				buttons: false,
			});
			console.log("Cannot load image");
			$("#blah").attr(
				"src",
				"https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png"
			);
		};
		img.onload = function () {
			URL.revokeObjectURL(this.src);
			const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
			const canvas = document.createElement("canvas");
			canvas.width = newWidth;
			canvas.height = newHeight;
			const ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0, newWidth, newHeight);
			canvas.toBlob((blob) => {}, MIME_TYPE, QUALITY);
			// document.getElementById("root").append(canvas);
			var dataURL = canvas.toDataURL();
			document.getElementById("putbas").value = dataURL;
		};
	};

	// ON INS
	function showTmp() {
		const api_url = "getTmp";
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			show(dat);
			if (!dat.length) {
				$("#btn-insert").prop("disabled", true);
			} else {
				$("#btn-insert").prop("disabled", false);
			}
		}
		getapi(api_url);
		function show(dat) {
			let tab = ``;

			// Loop to access all rows
			for (let r of dat) {
				tab += `<div class="row alert alert-info px-2 mx-0" role="alert"><div class="col-10 px-0 tom edit-tmp" onclick="modl('${r.id_aset_tmp}')">
                ${r.nama_aset}<b>, Code :</b>&nbsp;${r.code}</div>
                <div class="col-2 pl-0">
                <button type="button" class="close text-danger" onclick="delTmp('${r.id_aset_tmp}')" aria-label="Close">
                    <span >&times;</span>
                </button>
                </div></div>`;
			}
			document.getElementById("tmp").innerHTML = tab;
		}
	}

	function pass() {
		const url = "pass";
		const dat = {
			tujuan: document.getElementById("tuj").value,
			kategori: document.getElementById("kat").value,
			nama: document.getElementById("nam").value,
			code: document.getElementById("cod").value,
			img: document.getElementById("putbase").value,
			spesifikasi: document.getElementById("spek").value,
			deskripsi: document.getElementById("des").value,
		};
		if (!dat.code) {
			$.notify(
				{
					message:
						"Gagal Menambah Inventory semenatara, code inventory tidak boleh kosong",
				},
				{
					type: "danger",
					delay: 1100,
				}
			);
		} else {
			$(".subm").hide();
			$(".load").show();

			$.post(url, dat, function (data, status) {
				let k = JSON.parse(data);
				if (k.set == "sukses") {
					$.notify(
						{
							message: "Sukses Menambah Inventory semenatara",
						},
						{
							type: "info",
							delay: 1100,
						}
					);
					$(".subm").show();
					$(".load").hide();
					showTmp();
					clearTimeout(gum);
				} else {
					$.notify(
						{
							message: `Gagal Menambah Inventory semenatara, code aset sudah ada dengan nama <b>${k.nama_aset}</b>`,
						},
						{
							type: "danger",
							delay: 2000,
						}
					);
					$(".subm").show();
					$(".load").hide();
					showTmp();
					clearTimeout(gum);
				}
			});
		}
		var gum = setTimeout(function () {
			$.notify(
				{
					message: "Pastikan koneksi anda lancar, atau reload halaman",
				},
				{
					type: "warning",
					delay: 1100,
				}
			);
		}, 20000);
		return false;
	}

	function passUp() {
		const url = "updateTmp";
		const data = {
			id_aset: document.getElementById("id_aset_tmp").value,
			tujuan: document.getElementById("tujuan").value,
			kategori: document.getElementById("kategori").value,
			nama: document.getElementById("nama_aset").value,
			code: document.getElementById("code").value,
			img: document.getElementById("putbas").value,
			spesifikasi: document.getElementById("spesifikasi").value,
			deskripsi: document.getElementById("deskripsi").value,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				swal("Berhasil update data", {
					icon: "info",
					timer: 800,
					buttons: false,
				});
				showTmp();
			}
		});
	}

	function modl(id_aset) {
		$("#modaledit").modal("show");
		const id_aset_tmp = id_aset;
		$("#id_aset_tmp").val(id_aset_tmp);
		var api_url = "api?asetid=" + id_aset_tmp;

		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();

			if (response) {
				hideloader();
			}
			show(data);
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loading").style.display = "none";
			document.getElementById("fupdate").style.display = "block";
		}
		function show(data) {
			$("#kategori").val(data[0]["id_category"]);
			$("#tujuan").val(data[0]["id_user_tujuan"]);
			$("#nama_aset").val(data[0]["nama_aset"]);
			$("#code").val(data[0]["code"]);
			$("#blah").attr("src", data[0]["img"]);
			$("#spesifikasi").val(data[0]["spesifikasi"]);
			$("#deskripsi").val(data[0]["deskripsi"]);
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loading").style.display = "block";
			document.getElementById("fupdate").style.display = "none";
		}
	}

	function delTmp(id_aset) {
		var url = "delTmp";
		const data = {
			id_aset_tmp: id_aset,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				showTmp();
				$.notify(
					{
						message: "Inventory sementara telah dihapus",
					},
					{
						type: "info",
						delay: 1100,
					}
				);
			}
		});
	}

	function insert() {
		$(".allin").hide();
		$(".allload").show();
		const send = "tmpsend";
		async function sendWa(url) {
			const response = await fetch(url);
			await response;
		}
		sendWa(send);
		const api_url = "reqInvt";
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			masuk(dat);
		}
		getapi(api_url);
		function masuk(dat) {
			if (dat.respon == "habis") {
				$.notify(
					{
						message: "Inventory semenatara berhasil di request",
					},
					{
						type: "info",
						delay: 1100,
					}
				);
				$(".allin").show();
				$(".allload").hide();
			} else {
				$(".allin").hide();
				setTimeout(function () {
					getapi(api_url);
					showTmp();
				}, 100);
			}
		}
	}
	// END INS
	// ON REQ
	$(".modal").on("hidden.bs.modal", function (e) {
		$("#nam").val("");
		$("#cod").val("");
		$("#img1").val("");
		$("#bla").attr("hidden", true);
		$("#spek").val("");
		$("#des").val("");
	});
	function delReq(id_aset) {
		var url = "delReq";
		const data = {
			id_aset: id_aset,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				$.notify(
					{
						message: "Inventory request telah dihapus",
					},
					{
						type: "info",
						delay: 1100,
					}
				);
				dataTable();
			}
		});
	}

	function dataTable() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			let kp = dat;
			merg(kp);
		}
		getapi(api_url);
		function merg(kp) {
			ok = [];
			let no = 0;
			for (let i of kp) {
				no += 1;
				if (i.status == "R0") {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm">
           <span class="btn-label">
             <i class="fas fa-arrow-alt-circle-up"></i>
           </span>
           <b>Keluar</b>
         </div>`;
				} else {
					i.status = `<div class="btn btn-danger btn-border btn-round btn-sm">
            <span class="btn-label">
              <i class="fas fa-arrow-alt-circle-up"></i>
            </span>
            <b>Keluar Ditolak</b>
          </div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.tujuan_info[0]["nama_Admin"],
					i.status,
					`<div class="form-button-action">
          <button type="button" data-toggle="tooltip" onclick="inHistory('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-secondary btn-lg">
            <i class="fa fa-info-circle"></i>
          </button>  
          <button type="button" data-toggle="tooltip" onclick="updtReq('${i.id_aset}')" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
              <i class="fa fa-edit"></i>
          </button>
          <button type="button" data-toggle="tooltip" onclick="delReq('${i.id_aset}')" title="" class="btn btn-link btn-danger" data-original-title="Remove">
            <i class="fa fa-times"></i>
          </button>
          </div>`,
				];
				ok.push(obj);
			}
			$("#basic-datatables").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
			});
		}
	}
	function addReq() {
		const url = "addReq";
		const data = {
			tujuan: document.getElementById("tuj").value,
			kategori: document.getElementById("kat").value,
			nama: document.getElementById("nam").value,
			code: document.getElementById("cod").value,
			img: document.getElementById("putbase").value,
			spesifikasi: document.getElementById("spek").value,
			deskripsi: document.getElementById("des").value,
			lokasi: document.getElementById("loc").value,
		};
		console.log(data.lokasi);
		if (!data.code) {
			swal("Gagal menambah aset, code tidak boleh kosong!", {
				icon: "error",
				buttons: {
					confirm: {
						className: "btn btn-danger",
					},
				},
			});
		} else {
			$(".subm").hide();
			$(".load").show();
			const send = `addreqsend?nama_aset=${data.nama}&code=${data.code}&id_user_tujuan=${data.tujuan}`;
			async function sendWa(url) {
				const response = await fetch(url);
				await response;
			}
			sendWa(send);
			$.post(url, data, function (data, status) {
				let k = JSON.parse(data);
				if (k.set == "sukses") {
					$.notify(
						{
							message: "Sukses Menambah Inventory request",
						},
						{
							type: "info",
							delay: 1500,
						}
					);

					$(".subm").show();
					$(".load").hide();
					dataTable();
					$("#modaladd").modal("hide");
					clearTimeout(gum);
				} else {
					swal(
						"Gagal menambah Inventory",
						`code inventory sudah ada dengan nama ${k.nama_aset}`,
						{
							icon: "error",
							buttons: {
								confirm: {
									className: "btn btn-danger",
								},
							},
						}
					);
					$(".subm").show();
					$(".load").hide();
					dataTable();
					clearTimeout(gum);
				}
			});
		}
		var gum = setTimeout(function () {
			$.notify(
				{
					message: "Pastikan koneksi anda lancar, atau reload halaman",
				},
				{
					type: "warning",
					delay: 1100,
				}
			);
		}, 20000);
		return false;
	}
	function updtReq(id_aset) {
		$("#modaledit").modal("show");
		const id_aset_tmp = id_aset;
		$("#id_aset").val(id_aset_tmp);
		var api_url = "getReq?asetid=" + id_aset_tmp;

		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			if (response) {
				hideloader();
			}
			show(data);
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loading").style.display = "none";
			document.getElementById("fupdate").style.display = "block";
		}
		function show(data) {
			$("#katup").val(data[0]["id_category"]);
			$("#tujup").val(data[0]["id_user_tujuan"]);
			$("#nama_aset").val(data[0]["nama_aset"]);
			$("#code").val(data[0]["code"]);
			$("#blah").attr("src", data[0]["img"]);
			$("#spesifikasi").val(data[0]["spesifikasi"]);
			$("#deskripsi").val(data[0]["deskripsi"]);
			$("#lokasi").val(data[0]["lokasi"]);
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loading").style.display = "block";
			document.getElementById("fupdate").style.display = "none";
		}
	}
	function updateReq() {
		const url = "updateReq";
		const data = {
			id_aset: document.getElementById("id_aset").value,
			tujuan: document.getElementById("tujup").value,
			kategori: document.getElementById("katup").value,
			nama: document.getElementById("nama_aset").value,
			img: document.getElementById("putbas").value,
			spesifikasi: document.getElementById("spesifikasi").value,
			deskripsi: document.getElementById("deskripsi").value,
			lokasi: document.getElementById("lokasi").value,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				swal("Berhasil update data", {
					icon: "info",
					timer: 800,
					buttons: false,
				});
				dataTable();
				$("#modaledit").modal("hide");
			}
		});
	}

	function getBack() {
		const id_aset_tmp = $("#asetback").val();
		var api_url = "getReq?asetid=" + id_aset_tmp;

		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			show(data);
		}
		getapi(api_url);
		function show(data) {
			$("#descback").val(data[0]["deskripsi"]);
		}
	}
	function backReq() {
		const url = "backReq";
		const dat = {
			id_aset: document.getElementById("asetback").value,
			tujuan: document.getElementById("tujback").value,
			deskripsi: document.getElementById("descback").value,
		};
		$(".subm").hide();
		$(".load").show();
		$.post(url, dat, function (data, status) {
			if (status == "success") {
				$.notify(
					{
						message: "Sukses Menambah request aset kembali",
					},
					{
						type: "info",
						delay: 1100,
					}
				);

				$(".subm").show();
				$(".load").hide();

				dataTable();
				$("#asetback").find(`[value=${dat.id_aset}]`).remove();
				$("#asetback").selectpicker("refresh");
				document.getElementById("descback").value = "";
			}
		});

		return false;
	}
	// END REQ
	// Unconfirmed section
	function unTable() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			let kp = dat;
			merg(kp);
		}
		getapi(api_url);
		function merg(kp) {
			ok = [];
			let no = 0;
			for (let i of kp) {
				no += 1;
				if (!i.asal_info[0]) {
					i.asal_info[0] = { nama_Admin: "User dihapus" };
				}
				if (i.status == "R1") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm">
         <span class="btn-label">
           <i class="fas fa-arrow-alt-circle-down"></i>
         </span>
         <b>Masuk</b>
       </div>`;
				} else {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm">
         <span class="btn-label">
           <i class="fas fa-arrow-alt-circle-up"></i>
         </span>
         <b>Keluar</b>
       </div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.asal_info[0]["nama_Admin"],
					i.status,
					`<div class="form-button-action">
          <button type="button" data-toggle="tooltip" onclick="unDetail('${i.id_aset}')" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
            <i class="fa fa-edit"></i>
          </button>
          <button type="button" data-toggle="tooltip" onclick="inHistory('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-secondary btn-lg">
            <i class="fa fa-info-circle"></i>
          </button>
        </div>`,
				];
				ok.push(obj);
			}
			$("#untables").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
			});
		}
	}
	function unDetail(id_aset) {
		$("#modaledit").modal("show");
		const id_aset_tmp = id_aset;
		$("#id_aset").val(id_aset_tmp);
		var api_url = "getReq?asetid=" + id_aset_tmp;

		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			if (response) {
				hideloader();
			}
			show(data);
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loading").style.display = "none";
			document.getElementById("fupdate").style.display = "block";
		}
		function show(data) {
			if (!data[0].user_info[0]) {
				data[0].user_info[0] = { nama_Admin: "User dihapus" };
			}
			if (!data[0].kategori_info[0]) {
				data[0].kategori_info[0] = { nama_kategori: "Kategori dihapus" };
			}
			$("#katup").html(data[0].kategori_info[0]["nama_kategori"]);
			$("#tujup").html(data[0].user_info[0]["nama_Admin"]);
			$("#nama_aset").html(data[0]["nama_aset"]);
			$("#code").html(data[0]["code"]);
			$("#blah").attr("src", data[0]["img"]);
			$("#id_asal").val(data[0]["id_user_asal"]);
			$("#spesifikasi").val(data[0]["spesifikasi"]);
			$("#deskripsi").val(data[0]["deskripsi"]);
			$("#lok").val(data[0]["lokasi"]);
			$("#lokup").html(data[0]["lokasi"]);
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loading").style.display = "block";
			document.getElementById("fupdate").style.display = "none";
		}
	}
	function unAction(action) {
		let url = "actionUnc";
		let dat = {
			button: action,
			id_aset: document.getElementById("id_aset").value,
			id_asal: document.getElementById("id_asal").value,
		};
		$.post(url, dat, function (data, status) {
			if (data == 1) {
				swal("Berhasil konfirmasi", {
					icon: "info",
					timer: 800,
					buttons: false,
				});
				unTable();
				$("#modaledit").modal("hide");
			}
		});
	}
	// END Unconfirmed
	// Inventory all section
	function inventory() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			let kp = dat;
			merg(kp, kp.pop());
		}
		getapi(api_url);
		function merg(kp, sesid) {
			ok = [];
			no = 0;
			for (let i of kp) {
				no = no + 1;
				if (i.id_user_asal == sesid["sesid"]) {
					del = `<button type="button" data-toggle="tooltip" onclick="delInv('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-danger btn-lg"><i class="fa fa-times"></i></button></div>`;
					edt = `<button type="button" data-toggle="tooltip" onclick="updtInv('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-primary btn-lg" ><i class="fa fa-edit"></i></button>`;
				} else {
					del = ``;
					edt = `<button type="button" data-toggle="tooltip" onclick="inDetail('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-primary btn-lg"><i class="fa fa-eye"></i></button>`;
				}
				if (i.status == "1") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Didalam</b></div>`;
				} else {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Diluar</b></div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.user_info[0]["nama_Admin"],
					i.status,
					`<div class="form-button-action">${edt}<button type="button" data-toggle="tooltip" onclick="inHistory('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-secondary btn-lg">
                <i class="fa fa-info-circle"></i>
                </button>
                ${del}`,
				];
				ok.push(obj);
			}
			$("#asetall").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
			});
		}
	}

	function updtInv(id_aset) {
		const id_aset_tmp = id_aset;
		$("#id_aset_u").val(id_aset_tmp);
		var api_url = "getReq?asetid=" + id_aset_tmp;
		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			if (response) {
				hideloader();
			}
			if (data.respon == "kosong") {
				swal("Aset tidak di temukan", {
					icon: "error",
					timer: 1800,
					buttons: false,
				});
			} else {
				$("#modalupdate").modal("show");
				show(data);
			}
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loading_u").style.display = "none";
			document.getElementById("fupdate_u").style.display = "block";
		}
		function show(data) {
			$("#katup_u").val(data[0]["id_category"]);
			$("#nama_aset_u").val(data[0]["nama_aset"]);
			$("#code_u").val(data[0]["code"]);
			$("#blah").attr("src", data[0]["img"]);
			$("#spesifikasi_u").val(data[0]["spesifikasi"]);
			$("#deskripsi_u").val(data[0]["deskripsi"]);
			$("#lok_u").val(data[0]["lokasi"]);
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loading_u").style.display = "block";
			document.getElementById("fupdate_u").style.display = "none";
		}
	}
	function inDetail(id_aset) {
		const id_aset_tmp = id_aset;
		$("#id_aset").val(id_aset_tmp);
		var api_url = "getReq?asetid=" + id_aset_tmp;

		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			if (response) {
				hideloader();
			}
			if (data.respon == "kosong") {
				swal("Aset tidak di temukan", {
					icon: "error",
					timer: 1800,
					buttons: false,
				});
			} else {
				$("#modaledit").modal("show");
				show(data);
			}
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loading").style.display = "none";
			document.getElementById("fupdate").style.display = "block";
		}
		function show(data) {
			$("#katup").html(data[0].kategori_info[0]["nama_kategori"]);
			$("#tujup").html(data[0].user_info[0]["nama_Admin"]);
			$("#nama_aset").html(data[0]["nama_aset"]);
			$("#code").html(data[0]["code"]);
			$("#blah_det").attr("src", data[0]["img"]);
			$("#id_asal").val(data[0]["id_user_asal"]);
			$("#spesifikasi").val(data[0]["spesifikasi"]);
			$("#deskripsi").val(data[0]["deskripsi"]);
			$("#lokasi").html(data[0]["lokasi"]);
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loading").style.display = "block";
			document.getElementById("fupdate").style.display = "none";
		}
	}
	function inHistory(id_aset) {
		$("#modalhistory").modal("show");
		const id_aset_tmp = id_aset;
		var api_url = "getHis?asetid=" + id_aset_tmp;
		async function getapi(url) {
			const response = await fetch(url);
			var data = await response.json();
			if (response) {
				hideloader();
			}
			document.getElementById(
				"hisheader"
			).innerHTML = `Riwayat Aset, ${data[0].nama_aset} <div class="ml-auto"><i>${data[0].code}</i></div>`;
			show(data);
		}
		getapi(api_url);
		function hideloader() {
			document.getElementById("loadhis").style.display = "none";
			document.getElementById("stephis").style.display = "block";
		}
		function show(dat) {
			let tab = ``;
			for (let r of dat) {
				const d = new Date(`${r.date}`);
				r.date = new Intl.DateTimeFormat("id-GB", {
					dateStyle: "full",
					timeStyle: "short",
				}).format(d);
				if (!r.tujuan_info[0]) {
					r.tujuan_info[0] = { nama_Admin: "" };
				}
				if (r.status.includes("E") == false) {
					r.deskripsi = "";
				}
				if (r.status == "R1") {
					r.status = "Request Masuk dari";
					color = "feed-item-secondary";
				}
				if (r.status == "R0") {
					r.status = "Request Keluar dari";
					color = "feed-item-secondary";
				}
				if (r.status == "R1F") {
					r.status = "Diteruskan Masuk oleh";
					color = "feed-item-primary";
				}
				if (r.status == "R0F") {
					r.status = "Diteruskan Keluar oleh";
					color = "feed-item-primary";
				}
				if (r.status == "R0N") {
					r.status = "Request Keluar Ditolak oleh";
					color = "feed-item-danger";
				}
				if (r.status == "R0Y") {
					r.status = "Request Keluar Diterima oleh";
					color = "feed-item-success";
				}
				if (r.status == "R1N") {
					r.status = "Request Masuk Ditolak oleh";
					color = "feed-item-danger";
				}
				if (r.status == "R1Y") {
					r.status = "Request Masuk Diterima oleh";
					color = "feed-item-success";
				}
				if (r.status.includes("E") == true) {
					r.status = "Diedit oleh";
					color = "feed-item-warning";
				}
				if (r.status == "R1D") {
					r.status = "Request Masuk Dihapus";
					color = "feed-item-danger";
				}
				if (r.status == "R0D") {
					r.status = "Request Keluar dihapus";
					color = "feed-item-danger";
				}
				if (r.status == "R1FD") {
					r.status = "Request Diteruskan masuk dihapus";
					color = "feed-item-danger";
				}
				if (r.status == "R0FD") {
					r.status = "Request Diteruskan keluar dihapus";
					color = "feed-item-primary";
				}

				tab += `<li class="feed-item ${color}">
                    <time class="date">${r.date}</time>
                    <span class="text">${r.status} <b>${r.user_info[0].nama_Admin}</b> - <b>${r.tujuan_info[0].nama_Admin} </b><i>${r.deskripsi}</i></span>
                    </li>`;
			}
			document.getElementById("history").innerHTML = tab;
		}
		if (!$(".modal").hasClass("show")) {
			document.getElementById("loadhis").style.display = "block";
			document.getElementById("stephis").style.display = "none";
		}
	}
	function updateInv() {
		const url = "updateInv";
		const data = {
			id_aset: document.getElementById("id_aset_u").value,
			kategori: document.getElementById("katup_u").value,
			nama: document.getElementById("nama_aset_u").value,
			img: document.getElementById("putbas").value,
			spesifikasi: document.getElementById("spesifikasi_u").value,
			deskripsi: document.getElementById("deskripsi_u").value,
			lokasi: document.getElementById("lok_u").value,
		};
		$.post(url, data, function (data, status) {
			let k = JSON.parse(data);
			if (k.respon == "sukses") {
				swal("Berhasil update data", {
					icon: "info",
					timer: 800,
					buttons: false,
				});
				inventory();
				$("#modalupdate").modal("hide");
			} else {
				swal("Gagal update data", {
					icon: "error",
					text: "Anda hanya bisa mengedit aset dengan penanggung jawab anda sendiri!",
					timer: 1800,
					buttons: false,
				});
				$("#modalupdate").modal("hide");
			}
		});
	}
	function delInv(id_aset) {
		var url = "delReq";
		const data = {
			id_aset: id_aset,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				$.notify(
					{
						message: "Inventory request telah dihapus",
					},
					{
						type: "info",
						delay: 1100,
					}
				);
				inventory();
			}
		});
	}
	// END Inventory
	// SECTION PROFILE
	function profile() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			merg(dat);
		}
		getapi(api_url);
		function merg(dat) {
			if (dat.level == "1") {
				dat.level = "Superadmin";
			}
			if (dat.level == "2") {
				dat.level = "Guru";
			}
			if (dat.level == "3") {
				dat.level = "Buyer";
			}
			$("#name").val(dat.nama_Admin);
			$("#side-name").text(dat.nama_Admin);
			$("#name-h4").text(dat.nama_Admin);
			$("#email").val(dat.email);
			$("#email-h4").text(dat.email);
			$("#username").val(dat.username);
			$("#phone").val(dat.telp);
			$("#nameprfl").text(dat.nama_Admin);
			$("#foto").attr("href", dat.img);
			$("#foto1").attr("src", dat.img);
			$("#header-img").attr("src", dat.img);
			$("#header-img1").attr("src", dat.img);
			$("#header-img2").attr("src", dat.img);
			$("#level").text(dat.level);
		}
	}
	function resetPwd() {
		let passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
		if (!$("#pwdnew").val().match(passw)) {
			$("#errpwdnew").text(
				"*Password min 6 karakter berupa huruf besar & kecil, & angka"
			);
			pwd = "NO";
		} else {
			pwd = "YES";
		}
		if ($("#pwdnew").val() == $("#pwdnew1").val()) {
			pwd1 = "YES";
		} else {
			$("#errpwdnew1").text("*Password tidak sama dengan password baru");
			pwd1 = "NO";
		}
		if (pwd == "YES" && pwd1 == "YES") {
			const api_url = "cekpwd?pwd=" + $("#pwdold").val();
			async function cekusername(url) {
				const response = await fetch(url);
				var dat = await response.json();
				if (dat == "ok") {
					valid();
				} else {
					$("#errpwdold").text("*Password lama anda salah");
				}
			}
			cekusername(api_url);
			function valid() {
				$("#errpwdold").val("");
				$("#errpwdnew").val("");
				$("#errpwdnew1").val("");
				const url = "resetpwd";
				const data = {
					password: $("#pwdnew").val(),
				};
				$.post(url, data, function (data, status) {
					if (status == "success") {
						$.notify(
							{
								message: "Sukses Reset Password",
							},
							{
								type: "success",
								delay: 1500,
							}
						);
						$("#resetpwd").modal("hide");
					}
				});
				$("#pwdold").val("");
				$("#pwdnew").val("");
				$("#pwdnew1").val("");
			}
		}
		return false;
	}
	function getimg() {
		$("#change-img").modal("show");
		const api_url = "getimgprofile";
		async function cekusername(url) {
			const response = await fetch(url);
			var dat = await response.json();
			valid(dat);
		}
		cekusername(api_url);
		function valid(dat) {
			$("#blah").attr("src", dat);
			$("#putbas").val(dat);
		}
	}
	function imgUpdate() {
		const url = "updateImg";
		const data = {
			img: document.getElementById("putbas").value,
		};
		$.post(url, data, function (data, status) {
			if (status == "success") {
				swal("Berhasil update data", {
					icon: "info",
					timer: 800,
					buttons: false,
				});
			}
			profile();
			$("#change-img").modal("hide");
		});
		return false;
	}
	function updateProfile() {
		const api_url = "cekpwd?pwd=" + $("#pwdedit").val();
		async function cekusername(url) {
			const response = await fetch(url);
			var dat = await response.json();
			if (dat == "ok") {
				valid();
			} else {
				$("#errpwdedit").text("*Password anda salah");
			}
		}
		cekusername(api_url);
		function valid() {
			const url = "updateProfile";
			const data = {
				nama_Admin: $("#name").val(),
				email: $("#email").val(),
				username: $("#username").val(),
				telp: $("#phone").val(),
			};
			$.post(url, data, function (data, status) {
				let k = JSON.parse(data);
				if (k.username == 0) {
					pesan = "Username sudah dipakai silahkan gunakan username lain";
					stts = "error";
				} else if (k.email == 0) {
					pesan = "Email sudah dipakai silahkan gunakan email lain";
					stts = "error";
				} else if (k.telp == 0) {
					pesan = "No telp sudah dipakai silahkan gunakan no telp lain";
					stts = "error";
				} else {
					pesan = "sukses edit profile";
					stts = "info";
					profile();
					$("#changeprofile").modal("hide");
					$("#pwdedit").val("");
				}
				swal(`${pesan}`, {
					icon: `${stts}`,
					timer: 1400,
					buttons: false,
				});
			});
		}
		return false;
	}
	//END PROFILE
	// SECTION LAPORAN

	function laporan() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			let kp = dat;
			merg(kp, kp.pop());
		}
		getapi(api_url);
		function merg(kp, sesid) {
			ok = [];
			let no = 0;
			for (let i of kp) {
				if (!i.tujuan_info[0]) {
					i.tujuan_info[0] = { nama_Admin: "" };
				}
				no += 1;
				const d = new Date(`${i.date}`);
				i.date = new Intl.DateTimeFormat("id-GB", {
					dateStyle: "short",
					timeStyle: "short",
				}).format(d);
				if (i.status == "R0") {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Req Keluar</b></div>`;
				} else if (i.status == "R1") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk</b></div>`;
				} else if (i.status == "R1Y") {
					i.status = `<div class="btn btn-success btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Diterima</b></div>`;
				} else if (i.status == "R0Y") {
					i.status = `<div class="btn btn-success btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Req Keluar Diterima</b></div>`;
				} else if (i.status == "R1N") {
					i.status = `<div class="btn btn-danger btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Ditolak</b></div>`;
				} else if (i.status == "R0N") {
					i.status = `<div class="btn btn-danger btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Keluar Ditolak</b></div>`;
				} else if (i.status == "R1F") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Diteruskan</b></div>`;
				} else if (i.status == "R0F") {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Req Keluar Diteruskan</b></div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.date,
					i.user_info[0]["nama_Admin"],
					i.tujuan_info[0]["nama_Admin"],
					i.status,
				];
				ok.push(obj);
			}
			$("#basic-datatables").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
				responsive: true,
			});
		}
	}
	function filter() {
		const url = "filter";
		const data = {
			date1: $("#datepicker").val(),
			date2: $("#datepicker1").val(),
			tujuan: $("#tujuan").val(),
			status: $("#status").val(),
		};
		$.post(url, data, function (data, status) {
			let k = JSON.parse(data);
			merg(k);
		});
		function merg(kp) {
			ok = [];
			let no = 0;
			for (let i of kp) {
				if (!i.tujuan_info[0]) {
					i.tujuan_info[0] = { nama_Admin: "" };
				}
				no += 1;
				const d = new Date(`${i.date}`);
				i.date = new Intl.DateTimeFormat("id-GB", {
					dateStyle: "short",
					timeStyle: "short",
				}).format(d);
				if (i.status == "R0") {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Req Keluar</b></div>`;
				} else if (i.status == "R1") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk</b></div>`;
				} else if (i.status == "R1Y") {
					i.status = `<div class="btn btn-success btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Diterima</b></div>`;
				} else if (i.status == "R0Y") {
					i.status = `<div class="btn btn-success btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Req Keluar Diterima</b></div>`;
				} else if (i.status == "R1N") {
					i.status = `<div class="btn btn-danger btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Ditolak</b></div>`;
				} else if (i.status == "R0N") {
					i.status = `<div class="btn btn-danger btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Keluar Ditolak</b></div>`;
				} else if (i.status == "R1F") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Req Masuk Diteruskan</b></div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.date,
					i.user_info[0]["nama_Admin"],
					i.tujuan_info[0]["nama_Admin"],
					i.status,
				];
				ok.push(obj);
			}
			$("#basic-datatables").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
				responsive: true,
			});
			$("#modalfilter").modal("hide");
		}
		return false;
	}
	function exportPdf() {
		const url = "cetak_pdf";
		const data = {
			date1: $("#datepicker").val(),
			date2: $("#datepicker1").val(),
			tujuan: $("#tujuan").val(),
			status: $("#status").val(),
		};
		$.post(url, data, function (data, status) {
			download(data);
		});
		function download(data) {
			var link = document.createElement("a");
			//edit this after deploy
			let path = window.location.origin + "/demo/assets/" + data;
			link.download = data;
			link.href = path;
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
			delete link;

			const del = "deletePdf?path=" + data;
			async function getapi(del) {
				const response = await fetch(del);
				var dat = await response.json();
			}
			getapi(del);
		}
	}
	// END LAPORAN
	// SECTION SEARCH
	function search() {
		const api_url = link;
		async function getapi(url) {
			const response = await fetch(url);
			var dat = await response.json();
			let kp = dat;
			merg(kp, kp.pop());
		}
		getapi(api_url);
		function merg(kp, sesid) {
			ok = [];
			let no = 0;
			for (let i of kp) {
				no += 1;
				if (i.id_user_asal == sesid["sesid"]) {
					del = `<button type="button" data-toggle="tooltip" onclick="delInv('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-danger btn-lg"><i class="fa fa-times"></i></button></div>`;
					edt = `<button type="button" data-toggle="tooltip" onclick="updtInv('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-primary btn-lg" ><i class="fa fa-edit"></i></button>`;
				} else {
					del = ``;
					edt = `<button type="button" data-toggle="tooltip" onclick="inDetail('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-primary btn-lg"><i class="fa fa-eye"></i></button>`;
				}
				if (i.status == "1" || i.status == "R0N") {
					i.status = `<div class="btn btn-info btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-down"></i></span><b>Didalam</b></div>`;
				} else {
					i.status = `<div class="btn btn-warning btn-border btn-round btn-sm"><span class="btn-label"><i class="fas fa-arrow-alt-circle-up"></i></span><b>Diluar</b></div>`;
				}
				let obj = [
					no,
					i.nama_aset,
					i.code,
					i.user_info[0]["nama_Admin"],
					i.status,
					`<div class="form-button-action">${edt}<button type="button" data-toggle="tooltip" onclick="inHistory('${i.id_aset}')" title="" class="btn btn-link btn-icon btn-secondary btn-lg">
                <i class="fa fa-info-circle"></i>
                </button>
                ${del}`,
				];
				ok.push(obj);
			}
			$("#asetall").DataTable({
				pageLength: 5,
				bDestroy: true,
				data: ok,
			});
		}
	}
	// END SEARCH
	function calculateSize(img, maxWidth, maxHeight) {
		let width = img.width;
		let height = img.height;

		// calculate the width and height, constraining the proportions
		if (width > height) {
			if (width > maxWidth) {
				height = Math.round((height * maxWidth) / width);
				width = maxWidth;
			}
		} else {
			if (height > maxHeight) {
				width = Math.round((width * maxHeight) / height);
				height = maxHeight;
			}
		}
		return [width, height];
	}
	function readableBytes(bytes) {
		const i = Math.floor(Math.log(bytes) / Math.log(1024)),
			sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

		return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
	}
}
