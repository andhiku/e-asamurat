<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php
                    if ($data->foto != 'null') : echo base_url("assets/user/{$data->foto}");
                    else : echo base_url('assets/dist/img/no-images.png');
                    endif;
                    ?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?php echo $data->nama_lengkap; ?></h3>
                    <p class="text-muted text-center">Username : <?php echo $data->username; ?></p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Level Akses</b> <span class="pull-right"> <?php echo level_akses($data->level_akses); ?> </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom tab-warning">
                <ul class="nav nav-tabs">
                    <!--<li class="< ?php echo ($this->input->get('data')=='history') ? 'active' : ''; ?>"><a href="?data=history">Aktivitas</a></li>-->
                    <li class="<?php echo ($this->input->get('data') == 'update') ? 'active' : ''; ?>"><a href="?data=update">Ubah Data</a></li>
                    <li class="<?php echo ($this->input->get('data') == 'security') ? 'active' : ''; ?>"><a href="?data=security">Ganti Password</a></li>
                </ul>
                <div class="tab-content">
                    <!--                <div class="tab-pane < ?php echo ($this->input->get('data')=='history') ? 'active' : ''; ?>" id="activity">
                                    < ?php if(!count($data_history)) : ?>
                                      <div class="alert alert-default bg-gray alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-smile-o"></i> Tidak ada Hal yang anda lakukan hari ini</h4>
                                        Data ini akan terisi jika anda melakukan suatu hal seperti : Menambahkan Data, melakukan pencarian data, atau melakukan perubahan dan semua yang berkaitan pada data yang ada pada Database.
                                      </div>
                                    < ?php else : ?>
                    
                                        <table class="table table-bordered">
                                          <thead class="mini-font">
                                            <tr>
                                              <th width="10">No.</th>
                                              <th>Waktu</th>
                                              <th>Jenis Hak</th>
                                              <th>Nomor Hak</th>
                                              <th>Nomor 208</th>
                                              <th>Tahun</th>
                                              <th>Kelurahan</th>
                                              <th>Keterangan</th>
                                            </tr>
                                          </thead>
                                          <tbody class="mini-font">
                                            < ?php $no=(!$this->input->get('page')) ? 1 : $this->input->get('page'); foreach($data_history as $row) : ?>
                                            <tr>
                                              <td>< ?php echo $no++; ?>.</td>
                                              <td>< ?php echo $row->time; ?> <small><i><time class="timeago" datetime="< ?php echo $row->time; ?>">< ?php echo $row->time; ?></time></i></small></td>
                                              <td>< ?php echo $this->bpn->hak($row->id_hak); ?></td>
                                              <td>< ?php echo $row->no_hakbuku; ?></td>
                                              <td>< ?php echo $row->no208; ?></td>
                                              <td>< ?php echo $row->tahun; ?></td>
                                              <td>< ?php echo (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa); ?></td>
                                              <td>< ?php echo $row->deskripsi; ?></td>
                                            </tr>
                                            < ?php endforeach; ?>
                                          </tbody>
                                        </table>
                                    < ?php endif; ?>
                                      <div class="row">
                                      <hr>
                                        <div class="col-md-12">
                                          < ?php echo $this->pagination->create_links(); ?>
                                        </div>
                                      </div>
                                    </div>-->
                    <div class="tab-pane <?php echo ($this->input->get('data') == 'update') ? 'active' : ''; ?>" id="settings">
                        <form action="<?php echo site_url('setting/profile/update') ?>" id="form_update_profil" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nama lengkap<span class="text-danger">*</span><br><div style="color: red; margin: -1px 0; font-size: 70%;">(nama formal)</div></label>
                                <div class="col-sm-10">
                                    <input name="nama" type="text" value="<?php echo $data->nama_lengkap; ?>" class="form-control" placeholder="*Nama Lengkap..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input name="username" type="text" value="<?php echo $data->username; ?>" class="form-control" placeholder="*Username..." disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="status" name="status" disabled>
                                        <?php
                                        if ($data->level_akses == 'admin') :
                                            echo '<option name="akses" value="admin" selected> Administrator</option>
                                                <option name="akses" value="kalak"> Kepala Pelaksana</option>
                                                <option name="akses" value="kabag"> Kepala Bagian</option>
                                                <option name="akses" value="pelaksana"> Pelaksana</option>';
                                        elseif ($data->level_akses == 'super_admin') :
                                            echo '<option name="akses" value="super_admin" selected> Programmer</option>
                                                <option name="akses" value="kalak"> Kepala Pelaksana</option>
                                                <option name="akses" value="kabag"> Kepala Bagian</option>
                                                <option name="akses" value="pelaksana"> Pelaksana</option>';
                                        elseif ($data->level_akses == 'kalak') :
                                            echo '<option name="akses" value="admin"> Administrator</option>
                                                <option name="akses" value="kalak" selected> Kepala Pelaksana</option>
                                                <option name="akses" value="kabag"> Kepala Bagian</option>
                                                <option name="akses" value="pelaksana"> Pelaksana</option>';
                                        elseif ($data->level_akses == 'kabag') :
                                            echo '<option name="akses" value="admin"> Administrator</option>
                                                <option name="akses" value="kalak"> Kepala Pelaksana</option>
                                                <option name="akses" value="kabag" selected> Kepala Bagian</option>
                                                <option name="akses" value="pelaksana"> Pelaksana</option>';
                                        elseif ($data->level_akses == 'pelaksana') :
                                            echo '<option name="akses" value="admin"> Administrator</option>
                                                <option name="akses" value="kalak"> Kepala Pelaksana</option>
                                                <option name="akses" value="kabag"> Kepala Bagian</option>
                                                <option name="akses" value="pelaksana" selected> Pelaksana</option>';
                                        else : echo "-";
                                        endif;
                                        ?>
                                        <!--                                        <option name="akses" value="admin"> Administrator</option>
                                                                                <option name="akses" value="super_admin"> Programmer</option>
                                                                                <option name="akses" value="kalak"> Kepala Pelaksana</option>
                                                                                <option name="akses" value="kabag"> Kepala Bagian</option>
                                                                                <option name="akses" value="pelaksana"> Pelaksana</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bidang</label>
                                <div class="col-sm-10">
                                    <select name="bidang" class="form-control" id="bidang" disabled>
                                        <?php
                                        foreach ($this->mbpn->bidang() as $row) :
                                            if ($row->id_bidang == $data->id_bidang) {
                                                echo "<option name='bidang' value='{$row->id_bidang}' selected>" . ucwords(strtolower($row->nama_bidang)) . "</option>" . ",";
                                            } else {
                                                echo "<option name='bidang' value='{$row->id_bidang}'>" . ucwords(strtolower($row->nama_bidang)) . "</option>" . ",";
                                            }
                                        endforeach;
                                        ?>
                                    </select>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Foto Profil<br><div style="color: red; margin: -1px 0; font-size: 70%;">(opsional)</div></label>
                                <div class="col-sm-10">
                                    <input name="img" type="file">
                                    <input type="hidden" name="no_file" value="<?php echo $data->foto; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tanda Tangan<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" name="ttd" id="ttd" data-index="0" accept="image/x-png">
                                    <input type="hidden" name="no_ttd" value="<?php echo $data->ttd; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary pull-right" value="Simpan">
                                </div>
                            </div>
                            <hr>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php echo ($this->input->get('data') == 'security') ? 'active' : ''; ?>" id="pass">
                        <form class="form-horizontal" action="<?php echo site_url('setting/profile/update_pass') ?>" id="form_ganti_pass" method="post">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password Lama</label>
                                <div class="col-sm-10">
                                    <input name="lama" id="lama" type="password" class="form-control" placeholder="*Masukkan password lama..." autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password Baru</label>
                                <div class="col-sm-10">
                                    <input name="password" id="password" type="password" class="form-control" placeholder="*Masukkan password baru..." autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" class="pull-left" onclick="tampilPass()">&nbsp;&nbsp;Tampilkan Password
                                    </div>
                                    <input type="submit" class="btn btn-primary pull-right" value="Simpan">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<style>.mini-font { font-size:11px; }</style>
<script>
    function tampilPass() {
        var x = document.getElementById("lama");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        var y = document.getElementById("password");
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
    }
</script>
