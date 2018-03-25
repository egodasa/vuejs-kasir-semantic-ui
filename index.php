<html>

<head>
	<title>Kasir</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kasir</title>
	<link rel="stylesheet" href="assets/adminlte/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/adminlte/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/adminlte/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/adminlte/css/AdminLTE.min.css">
	<link rel="stylesheet" href="assets/adminlte/skins/_all-skins.min.css">
	<link rel="stylesheet" href="assets/adminlte/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>

<body>
	<script src="vue.js"></script>
	<div id="kasir" class="wrapper">
		<div class="container">	
			<template v-if="listTrx.length >= 1">
				<div class="modal fade in" :style="styleModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" @click="modal = !modal"><span aria-hidden="true">×</span></button>
								<h4 class="modal-title">{{'Detail Transaksi '+ listTrx[selectedId].id_trx}}</h4>
							</div>
							<div class="modal-body">
								<table class="table table-hover table-bordered">
								<thead>
								<tr>
									<th>Nama</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Total Harga</th>
								</tr>
								</thead>
								<tbody>
								<tr v-for="x in listTrx[selectedId].detail">
									<td>{{x.nm_item}}</td>
									<td>{{x.hrg_item}}</td>
									<td>{{x.jml_item}}</td>
									<td>{{x.hrg_item*x.jml_item}}</td>
								</tr>
								</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger" @click="toggleModal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</template>
			<form class="ui form" @submit.prevent="addItem">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label>ID TRX</label>
							<input v-model="id_trx" class="form-control" disabled />
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label>Total Bayar</label>
							<input v-model="total_hrg" class="form-control" disabled />
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label>Jumlah Dibayar</label>
							<input v-model="dibayar" class="form-control" />
						</div>
					</div>
					<div class="col-xs-12">
						<div class="form-group">
							<label>Kembalian</label>
							<input v-model="kembalian" class="form-control" disabled/>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-block btn-primary" @click="addTrx">Simpan Trx</button>
							<button type="button" class="btn btn-block btn-danger" @click="resetTrx">Reset Trx</button>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Nama Barang</label>
							<input v-model="nm_item" class="form-control" placeholder="nama item" />
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Harga Barang</label>
							<input v-model.Number="hrg_item" class="form-control" placeholder="harga" />
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Jumlah Beli</label>
							<input v-model.Number="jml_item" class="form-control" placeholder="jumlah" />
						</div>
					</div>
					<div class="col-xs-12">
						<div class="form-group">
							<button type="submit" class="btn btn-block btn-primary">Tambahkan Ke trx</button>
							<button type="reset" class="btn btn-block btn-danger">Reset</button>
						</div>
					</div>
				</div>
			</form>
			<h2>Daftar Beli</h2>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Total Harga</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="listTrx.length == 0">
						<tr>
							<td colspan="4" class="text-center">Daftar Beli Kosong</td>
						</tr>
					</template>
					<template v-else>
						<tr v-for="x in listItemTmp">
							<td>{{x.nm_item}}</td>
							<td>{{x.hrg_item}}</td>
							<td>{{x.jml_item}}</td>
							<td>{{x.hrg_item*x.jml_item}}</td>
						</tr>
					</template>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">Total</td>
						<td>{{jml}}</td>
						<td>{{total_hrg}}</td>
					</tr>
				</tfoot>
			</table>
			<h2>Transaksi</h2>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID TRX</th>
						<th>Jumlah</th>
						<th>Total Harga</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="listTrx.length == 0">
						<tr>
							<td colspan="4" class="text-center">Transaksi Kosong</td>
						</tr>
					</template>
					<template v-else>
						<tr v-for="(x,index,key) in listTrx">
							<td>{{x.id_trx}}</td>
							<td>{{x.jml}}</td>
							<td>{{x.total_hrg}}</td>
							<td><button class="btn btn-primary" @click="showDetail(index)">Detail</button></td>
						</tr>
					</template>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		new Vue({
			el: "#kasir",
			data() {
				return {
					id_trx: new Date().getTime().toString(),
					nm_item: null,
					hrg_item: null,
					jml_item: null,
					listItemTmp: [],
					listTrx: [],
					total_hrg: 0,
					jml: 0,
					modal: false,
					styleModal: 'display:none;',
					selectedId: null,
					dibayar : 0
				}
			},
			computed : {
				kembalian : function(){
					while(this.dibayar - this.total_hrg >= 0){
						return this.dibayar - this.total_hrg
					}
				}
			},
			methods: {
				toggleModal() {
					this.modal = !this.modal
					if (this.modal) this.styleModal = "display:block;"
					else this.styleModal = "display:none;"
				},
				addItem() {
					this.listItemTmp.push({
						nm_item: this.nm_item,
						hrg_item: this.hrg_item,
						jml_item: this.jml_item
					})
					this.nm_item = null
					this.hrg_item = null
					this.jml_item = null
					this.total_hrg = 0
					this.jml = 0
					for (let x = 0; x < this.listItemTmp.length; x++) {
						this.total_hrg += this.listItemTmp[x].hrg_item * this.listItemTmp[x].jml_item
						this.jml += this.listItemTmp[x].jml_item
					}
				},
				addTrx() {
					this.listTrx.push({
						id_trx: this.id_trx,
						jml: this.jml,
						total_hrg: this.total_hrg,
						detail: this.listItemTmp
					})
					this.id_trx = new Date().getTime().toString()
					this.nm_item = null
					this.hrg_item = null
					this.jml_item = null
					this.total_hrg = 0
					this.jml = 0
					this.listItemTmp = []
					this.selectedId = 0
					this.kembalian = 0
					this.dibayar = 0
				},
				showDetail(x) {
					this.selectedId = x
					this.toggleModal()
				},
				resetTrx(){
					this.listItemTmp = []
					this.selectedId = 0
					this.kembalian = 0
					this.dibayar = 0
					this.nm_item = null
					this.hrg_item = null
					this.jml_item = null
					this.total_hrg = 0
					this.jml = 0
					this.id_trx = new Date().getTime().toString()
				}
			}
		})
	</script>
	<script src="assets/js/app_adminlte.js"></script>
</body>

</html>