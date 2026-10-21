
<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$mobil = $mobil ?? [];
$flash = $flash ?? null;
$mode = $mode ?? null;
$mobil_dipilih = $mobil_dipilih ?? null;
$flashClass = (($flash['type'] ?? '') === 'success')
    ? 'alert-success'
    : 'alert-danger';
$error = $error ?? null;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manajemen Kendaraan
            <small>Kelola data kendaraan</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= htmlspecialchars(
                    site_url('admin'),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Manajemen Kendaraan</li>
        </ol>
    </section>

    <section class="content">
        <?php if ($mode === 'tambah'): ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tambah Kendaraan</h3>
        </div>
<div class="box-body">
    <form method="post"
    enctype="multipart/form-data"
    action="<?= htmlspecialchars(site_url('admin/mobil/tambah'), ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
            <label>Nomor Plat</label>
            <input type="text" name="no_plat"
                class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Mobil</label>
            <input type="text" name="nm_mobil"
                class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah Kursi</label>
            <input type="number" name="nkursi"
                class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label>Jumlah Bagasi</label>
            <input type="number" name="nbagasi"
                class="form-control" min="0" required>
        </div>

        <div class="form-group">
            <label>Jenis Mobil</label>
            <select name="jns_mobil" class="form-control" required>
                <option value="">-- Pilih Jenis Mobil --</option>
                <option value="SUV">SUV</option>
                <option value="MPV">MPV</option>
                <option value="City Car">City Car</option>
            </select>
        </div>

        <div class="form-group">
            <label>Transmisi</label>
            <select name="transmisi" class="form-control" required>
                <option value="">-- Pilih Transmisi --</option>
                <option value="AT">AT</option>
                <option value="MT">MT</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tahun Pembuatan</label>
            <input type="number" name="thn_buat"
                class="form-control" min="1901"
                max="<?= date('Y') ?>" required>
        </div>
<div class="form-group">
    <label for="ft_depan">Foto Depan Mobil</label>
    <input type="file" class="form-control" id="ft_depan"
        name="ft_depan" accept="image/jpeg,image/png,image/webp">
    <p class="help-block">Format JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
</div>

<div class="form-group">
    <label for="ft_blkg">Foto Belakang Mobil</label>
    <input type="file" class="form-control" id="ft_blkg"
        name="ft_blkg" accept="image/jpeg,image/png,image/webp">
    <p class="help-block">Format JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
</div>

<div class="form-group">
    <label for="ft_interior">Foto Interior Mobil</label>
    <input type="file" class="form-control" id="ft_interior"
        name="ft_interior" accept="image/jpeg,image/png,image/webp">
    <p class="help-block">Format JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
</div>
        <div class="form-group">
            <label>Harga Sewa per Hari</label>
            <input type="number" name="hrg_hari"
                class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label>Catatan Unit</label>
            <textarea name="cttn_unit"
                class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Status Kendaraan</label>
            <select name="status_unit" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="tersedia">Tersedia</option>
                <option value="disewa">Disewa</option>
                <option value="tidaktersedia">Tidak Tersedia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Kendaraan
        </button>

        <a href="<?= htmlspecialchars(
            site_url('admin/mobil'),
            ENT_QUOTES,
            'UTF-8'
        ) ?>" class="btn btn-default">
            Kembali
        </a>
    </form>
</div>
    </div>
<?php endif; ?>

        <?php if (!empty($flash)): ?>
            <div class="alert <?= $flashClass ?> alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <?= htmlspecialchars(
                    $flash['message'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Kendaraan</h3>

                <div class="box-tools">
                    <a href="<?= htmlspecialchars(
                        site_url('admin/mobil/tambah'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Kendaraan
                    </a>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table id="mobilTable"
                        class="table table-bordered table-striped js-data-table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Plat</th>
                                <th>Nama Mobil</th>
                                <th>Kursi</th>
                                <th>Bagasi</th>
                                <th>Jenis Mobil</th>
                                <th>Transmisi</th>
                                <th>Tahun</th>
                                <th>Harga/Hari</th>
                                <th>Status</th>
                                <th>Foto Depan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($mobil)): ?>
                                <tr>
                                    <td colspan="12" class="text-center">
                                        Data kendaraan belum tersedia.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($mobil as $no => $item): ?>
                                    <tr>
                                        <td><?= (int) $no + 1 ?></td>

                                        <td><?= htmlspecialchars(
                                            $item['no_plat'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?></td>

                                        <td><?= htmlspecialchars(
                                            $item['nm_mobil'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?></td>

                                        <td><?= (int) ($item['nkursi'] ?? 0) ?></td>
                                        <td><?= (int) ($item['nbagasi'] ?? 0) ?></td>

                                        <td><?= htmlspecialchars(
                                            $item['jns_mobil'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?></td>

                                        <td><?= htmlspecialchars(
                                            $item['transmisi'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?></td>

                                        <td><?= htmlspecialchars(
                                            (string) ($item['thn_buat'] ?? ''),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?></td>

                                        <td>Rp <?= number_format(
                                            (int) ($item['hrg_hari'] ?? 0),
                                            0,
                                            ',',
                                            '.'
                                        ) ?></td>

                                        <td>
                                            <?php
                                            $status = $item['status_unit'] ?? '';
                                            $statusClass = match ($status) {
                                                'tersedia' => 'label-success',
                                                'disewa' => 'label-warning',
                                                'tidaktersedia' => 'label-danger',
                                                default => 'label-default',
                                            };
                                            ?>
                                            <span class="label <?= $statusClass ?>">
                                                <?= htmlspecialchars(
                                                    $status,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if (!empty($item['ft_depan'])): ?>
                                                <img
                                                    src="<?= htmlspecialchars(
                                                        base_url(
                                                            'uploads/mobil/' .
                                                            rawurlencode($item['ft_depan'])
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>"
                                                    alt="Foto kendaraan"
                                                    style="width:80px;height:55px;object-fit:cover;">
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    Belum ada foto
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <a class="btn btn-warning btn-xs"
                                                href="<?= htmlspecialchars(
                                                    site_url(
                                                        'admin/mobil/ubah/' .
                                                        rawurlencode(
                                                            (string) $item['no_plat']
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>">
                                                <i class="fa fa-edit"></i> Ubah
                                            </a>

                                            <form method="post"
                                                style="display:inline"
                                                action="<?= htmlspecialchars(
                                                    site_url(
                                                        'admin/mobil/hapus/' .
                                                        rawurlencode(
                                                            (string) $item['no_plat']
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                                onsubmit="return confirm('Hapus kendaraan ini?');">
                                                <button type="submit"
                                                    class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if ($error !== null): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

    </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>
