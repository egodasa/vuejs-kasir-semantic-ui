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
	<style>
	body{
		background-color: #ecf0f5;
	}
	</style>
</head>

<body>
	<script src="assets/js/vue.js"></script>
	<script src="assets/js/store/dist/store.modern.min.js"></script>
	<div id="kasir" class="wrapper">
		<div class="container">	
<!--
			Modal Detail Trx
-->
			<template v-if="listTrx.length >= 1">
				<div class="modal fade in" :style="styleModalTrxDetail">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" @click="toggleModal('trx')"><span aria-hidden="true">×</span></button>
								<h4 class="modal-title">{{'Detail Transaksi '+ listTrx[selectedId].id_trx}}</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label>Total Bayar</label>
											<p>{{listTrx[selectedId].total_hrg}}</p>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label>Tanggal Transaksi</label>
											<p>{{listTrx[selectedId].tgl_trx.toString()}}</p>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label>Dibayar</label>
											<p>{{listTrx[selectedId].dibayar}}</p>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
										<label>Kembalian</label>
										<p>{{listTrx[selectedId].kembalian}}</p>
									</div>
									</div>
								</div>
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
								<button class="btn btn-danger" @click="toggleModal('trx')">Close</button>
							</div>
						</div>
					</div>
				</div>
			</template>
<!--
			Modal Produk
-->
			<div class="modal fade in" :style="styleModalProduk">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4>Daftar Produk</h4>
							</div>
							<div class="modal-body">
								<form class="ui form" @submit.prevent="addProduk">
									<div class="row">
										<div class="col-xs-12">
											<div class="form-group">
												<label>Nama Produk</label>
												<input v-model="nm_produk" class="form-control"/>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>Harga Produk</label>
												<input v-model.Number="hrg_produk" type="number" class="form-control"/>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>Stok</label>
												<input v-model.Number="stok" type="number" class="form-control"/>
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-primary">Tambah Produk</button>
								</form>
								<table class="table table-hover table-bordered">
								<thead>
								<tr>
									<th>Nama</th>
									<th>Harga</th>
									<th>Stok</th>
								</tr>
								</thead>
								<tbody>
								<tr v-for="x in listProduk">
									<td>{{x.nm_produk}}</td>
									<td>{{x.hrg_produk}}</td>
									<td>{{x.stok}}</td>
								</tr>
								</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger" @click="toggleModal('produk')">Close</button>
							</div>
						</div>
					</div>
				</div>
<!--
		Tambah Item ke trx
-->		<div class="box">
			<div class="box-body">
				<form @submit.prevent="addItem">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>ID TRX</label>
								<input v-model="id_trx" class="form-control" disabled />
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
								<label>Nama Barang</label>
								<select ref="pilihItem" v-model="selectedProduk" class="form-control">
									<option v-for="x in listProduk" :value="x">{{x.nm_produk}}</option>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
								<label>Harga Barang</label>
								<input type="number" v-model.Number="selectedProduk.hrg_produk" class="form-control" placeholder="harga" disabled />
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
								<label>Jumlah Beli</label>
								<input type="number" v-model.Number="jml_item" class="form-control" placeholder="jumlah" />
							</div>
						</div>
						<div class="col-md-2 col-xs-12">
							<div class="form-group">
								<button type="reset" class="btn btn-block btn-danger">Reset</button>
							</div>
						</div>
						<div class="col-md-7 col-xs-12">
							<div class="form-group">
								<button type="submit" class="btn btn-block btn-primary">Tambahkan Ke trx</button>
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<div class="form-group">
								<button type="button" class="btn btn-block btn-primary" @click="toggleModal('produk')">Tambah Produk</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
<!--
			Daftar item pada trx
-->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Barang yang dibeli</h3>
			</div>
			<div class="box-body">
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
						<template v-if="listItemTmp.length == 0">
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
			</div>
		</div>
<!--
			Form pembayaran
-->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Pembayaran</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label>Total Bayar</label>
							<input v-model="total_hrg" class="form-control" disabled />
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label>Jumlah Dibayar</label>
							<input type="number" v-model="dibayar" class="form-control" />
						</div>
					</div>
					<div class="col-xs-12">
						<div class="form-group">
							<label>Kembalian</label>
							<input v-model="kembalian" class="form-control" disabled/>
						</div>
					</div>
					
					<div class="col-md-2 col-xs-12">
						<div class="form-group">
							<button type="button" class="btn btn-block btn-danger" @click="resetTrx">Reset Trx</button>
						</div>
					</div>
					<div class="col-md-10 col-xs-12">
						<div class="form-group">
							<button type="button" class="btn btn-block btn-primary" @click="addTrx">Simpan Trx</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--
			Tabel trx
-->
		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title">Daftar Transaksi</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID TRX</th>
							<th>Tanggal TRX</th>
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
								<td>{{x.tgl_trx.toString()}}</td>
								<td>{{x.jml}}</td>
								<td>{{x.total_hrg}}</td>
								<td><button class="btn btn-primary" @click="showDetail(index)">Detail</button></td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
			<div class="footer">
				<div class="pull-right"><b>Created By <a href="https://github.com/egodasa">Ego Dafma Dasa</a></b></div>
			</div>
		</div>
	</div>
	<script>
		Vue.prototype.$lcs = store
		new Vue({
			el: "#kasir",
			data() {
				return {
					id_trx: new Date().getTime().toString(),
					jml_item: null,
					listItemTmp: [],
					listTrx: [],
					total_hrg: 0,
					jml: 0,
					modalTrxDetail: false,
					styleModalTrxDetail: 'display:none;',
					selectedId: 0,
					dibayar : 0,
					listProduk : [
						{id_produk : "1", nm_produk : "Keyboard", hrg_produk : 250000, stok : 10},
						{id_produk : "2", nm_produk : "Mouse", hrg_produk : 25000, stok : 20}
					],
					hrg_produk : 0,
					stok : 0,
					modalProduk: false,
					styleModalProduk: 'display:none;',
					selectedProduk : {},
					nm_produk : null
				}
			},
			computed : {
				kembalian : function(){
					if(this.dibayar - this.total_hrg >= 0) {
						return this.dibayar - this.total_hrg
					}else{
						return 'Kurang Rp.'+(this.dibayar - this.total_hrg)*-1
					}
				}
			},
			created (){
				if(!this.$lcs.get('app_kasir')){
					this.$lcs.set('app_kasir',{listProduk:this.listProduk,listTrx:this.listTrx})
				}else{
					let data = this.$lcs.get('app_kasir')
					this.listProduk = data.listProduk
					this.listTrx = data.listTrx
				}
			},
			methods: {
				setDataStorage(){
					this.$lcs.set('app_kasir',{listProduk:this.listProduk,listTrx:this.listTrx})
				},
				addProduk (){
					this.listProduk.push({
						id_produk : new Date().getTime().toString(),
						nm_produk : this.nm_produk,
						hrg_produk : this.hrg_produk,
						stok : this.stok
					})
					this.setDataStorage()
					this.resetProduk()
				},
				resetProduk (){
					this.nm_produk = null
					this.hrg_produk = 0
					this.stok = 0
				},
				resetListItem (){
					this.listItemTmp = []
					this.resetItem()
				},
				resetItem (){
					this.selectedProduk = {}
					this.selectedProduk.hrg_produk = 0
					this.jml_item = null
				},
				resetTrx (){
					this.selectedId = 0
					this.kembalian = 0
					this.dibayar = 0
					this.total_hrg = 0
					this.jml = 0
					this.id_trx = new Date().getTime().toString()
					this.resetListItem()
					this.resetItem()
				},
				toggleModal(modal) {
					if(modal == 'trx'){
						this.modalTrxDetail = !this.modalTrxDetail
						if (this.modalTrxDetail) this.styleModalTrxDetail = "display:block;"
						else this.styleModalTrxDetail = "display:none;"
					}else{
						this.modalProduk = !this.modalProduk
						if (this.modalProduk) this.styleModalProduk = "display:block;"
						else this.styleModalProduk = "display:none;"
					}
				},
				addItem() {
					this.listItemTmp.push({
						nm_item: this.selectedProduk.nm_produk,
						hrg_item: this.selectedProduk.hrg_produk,
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
					this.$refs.pilihItem.focus()
				},
				addTrx() {
					this.listTrx.push({
						id_trx: this.id_trx,
						jml: this.jml,
						total_hrg: this.total_hrg,
						kembalian : this.kembalian,
						dibayar : this.dibayar,
						detail: this.listItemTmp,
						tgl_trx : new Date()
					})
					this.setDataStorage()
					this.resetTrx()
				},
				showDetail(x) {
					this.selectedId = x
					this.toggleModal('trx')
				}
			}
		})
	</script>
	<script src="assets/js/app_adminlte.js"></script>
</body>

</html>
