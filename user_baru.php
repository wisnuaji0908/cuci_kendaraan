<?php
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header('Location: ./');
    die();
} else {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $hp = $_POST['hp'];
        $level = $_POST['level'];

        // check if username already exists
        $query_check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
        if (mysqli_num_rows($query_check) > 0) {
            $_SESSION['err'] = '<strong>ERROR!</strong> Username sudah ada.';
            header('Location: ./admin.php?hlm=user');
            die();
        }

        // prepare the query
        $stmt = mysqli_prepare($koneksi, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssssi', $username, $password, $nama, $alamat, $hp, $level);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: ./admin.php?hlm=user');
            die();
        } else {
            $_SESSION['err'] = '<strong>ERROR!</strong> Periksa penulisan querynya.';
            header('Location: ./admin.php?hlm=user');
            die();
        }
    } else {
	
?>
<h2>Tambah User Baru</h2>
<hr>
<form method="post" action="" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">Username</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label">Password</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="username" name="password" placeholder="Password" required>
		</div>
	</div>
	<div class="form-group">
		<label for="nama" class="col-sm-2 control-label">Nama User</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama User" required>
		</div>
	</div>
	<div class="form-group">
		<label for="alamat" class="col-sm-2 control-label">Alamat</label>
		<div class="col-sm-6">
			<textarea class="form-control" name="alamat" rows="4" required></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="hp" class="col-sm-2 control-label">Nomor HP</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="hp" name="hp" placeholder="Nomor HP" required>
		</div>
	</div>
	<div class="form-group">
		<label for="jenis" class="col-sm-2 control-label">Jenis User</label>
		<div class="col-sm-3">
			<select name="level" class="form-control" required>
				<option value="">Pilih Jenis User</option>
				<option value="2">Petugas</option>
				<option value="1">Admin</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-success">Simpan</button>
			<a href="./admin.php?hlm=user" class="btn btn-danger">Batal</a>
		</div>
	</div>
</form>
<?php
	}
}
?>
