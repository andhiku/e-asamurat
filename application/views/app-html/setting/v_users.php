<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$session = $this->session->userdata('login');
$data_user = $this->db->query("SELECT * FROM tb_users WHERE username = '{$session['username']}'")->row();
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="col-md-5">
                        <a href="" class="btn btn-default" title="Tambahkan User" data-toggle="modal" data-target="#addUser"><i class="fa fa-user-plus"></i> Tambahkan User</a>
                    </div>
                    <div class="col-md-7">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th width="10px;"><i class="fa fa-laptop"></i></th>
                            <th width="10px;">#</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <!--<th>Email</th>-->
                            <th>Jabatan</th>
                            <th>Bidang</th>
                            <th class="text-center">Tanda Tangan</th>
                            <th>Status</th>
                            <th width="100px;"></th>
                        </tr>
                        <?php
                        $no = (!$this->input->get('page')) ? 0 : $this->input->get('page');
                        foreach ($data_users as $row) :
//                            $bid = $this->bpn->bidang($row->id_bidang);
                            ?>
                            <tr>
                                <td><?php
                                    if ($row->status == 'online') {
                                        echo '<i class="fa fa-circle text-green" title="Sedang Aktif"></i>';
                                    } else {
                                        echo '<i class="fa fa-circle text-gray" title="Tidak Aktif"></i>';
                                    }
                                    ?></td>
                                <td><?php echo ++$no; ?>.</td>
                                <td><?php echo $row->username; ?></td>
                                <td><?php echo ucwords(strtolower($row->nama_lengkap)); ?></td>
                                <!--<td><?php // echo $row->email;    ?></td>-->
                                <td><?php
                                    if ($row->level_akses == 'admin') : echo 'Administrator';
                                    elseif ($row->level_akses == 'kalak') : echo 'Kepala Pelaksana';
                                    elseif ($row->level_akses == 'kabag') : echo 'Kepala Bagian';
                                    elseif ($row->level_akses == 'pelaksana') : echo 'Pelaksana';
                                    elseif ($row->level_akses == 'super_admin') : echo 'Programmer';
                                    else : echo "-";
                                    endif;
                                    ?></td>
                                <td><?php
                                    if ($row->id_bidang != 0) :
                                        echo ucwords(strtolower(tempel('tb_bidang', 'nama_bidang', "id_bidang = '$row->id_bidang'")));
//                                        echo $row->id_bidang;
                                    else :
                                        echo ' - ';
                                    endif;
                                    ?></td>
                                <td class="text-center"><?php
                                    if ($row->ttd != '') {
                                        echo "<span class='glyphicon glyphicon-ok text-green' title='Sudah ada'></span>";
                                    } else {
                                        echo "<span class='glyphicon glyphicon-remove text-red' title='Belum ada'></span>";
                                    }
                                    ?></td>
                                <td><?php echo ($row->status_user == 'valid') ? 'Whitelist' : 'Blacklist'; ?></td>
                                <td>
                                    <?php if ($row->status_user == 'valid') : ?>
                                        <a href="<?php echo site_url("setting/cusers/block/{$row->id}?method=valid") ?>" class="btn btn-xs btn-default" title="Block User"><i class="fa fa-unlock text-green"></i></a>
                                    <?php else : ?>
                                        <a href="<?php echo site_url("setting/cusers/block/{$row->id}?method=not") ?>" class="btn btn-xs btn-default" title="Unblock User"><i class="fa fa-lock text-warning"></i></a>
                                    <?php endif; ?>
                                    <a href="#" onclick="delete_user('<?php echo $row->username; ?>');" class="btn btn-xs btn-default" title="Hapus User"><i class="fa fa-trash-o text-red"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?> 
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<style>  .top { margin-top:20px; }</style>




<!--dialog area-->
<div class="modal fade modal-default" id="addUser" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Menambahkan User Baru</h4>
            </div>
            <form enctype="multipart/form-data" action="<?php echo site_url('setting/cusers/add') ?>" id="form_add_user" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap :</label>
                                    <input name="nama" type="text" class="form-control" placeholder="*Masukkan Nama Lengkap" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username :</label>
                                    <input name="username" type="text" class="form-control" placeholder="*Masukkan Username" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanda Tangan :</label>
                                    <input type="file" class="form-control" name="userfile" id="userfile" data-index="0" accept="image/x-png"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jabatan :</label>
<!--                                    <select class="form-control" id="sel1">
                                        <option name="akses" id="status0" value="">- PILIHAN -</option>
                                        <option name="akses" id="status1" value="super_admin"> Programmer</option>
                                        <option name="akses" id="status2" value="admin"> Administrator</option>
                                        <option name="akses" id="status3" value="kalak"> Kepala Pelaksana</option>
                                        <option name="akses" id="status4" value="kabag"> Kepala Bagian</option>
                                        <option name="akses" id="status5" value="pelaksana"> Pelaksana</option>
                                    </select>-->
                                    <div class="radio">
<!--                                        <label>
                                            <input type="radio" name="akses" id="status1" value="super_admin"> Programmer
                                        </label><br>-->
                                        <label class="left">
                                            <input type="radio" name="akses" id="status2" value="admin"> Administrator
                                        </label><br>
                                        <label class="left">
                                            <input type="radio" name="akses" id="status3" value="kalak"> Kepala Pelaksana
                                        </label><br>
                                        <label class="left">
                                            <input type="radio" name="akses" id="status4" value="kabag"> Kepala Bagian
                                        </label><br>
                                        <label class="left">
                                            <input type="radio" name="akses" id="status5" value="pelaksana"> Pelaksana
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bidang :</label>
                                    <select name="bidang" class="form-control select" style="width: 255px;">
                                        <option value="">- PILIHAN -</option>
                                        <?php
                                        foreach ($this->mbpn->bidang() as $row) : echo "<option value='{$row->id_bidang}'>{$row->nama_bidang}</option>" . ",";
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pull-right">
<!--                                <div class="form-group">
                                    <label>Bidang :</label>
                                    <select name="bidang" class="form-control select" style="width: 255px;">
                                        <option value="">- PILIHAN -</option>
                                        <?php
//                                        foreach ($this->mbpn->bidang() as $row) : echo "<option value='{$row->id_bidang}'>{$row->nama_bidang}</option>" . ",";
//                                        endforeach;
                                        ?>
                                    </select>
                                </div>-->
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-key"></i>
                                        </div>
                                        <input name="pass" type="password" class="form-control" placeholder="*Masukkan password" required>
                                    </div><!-- /.input group -->   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ulangi Password :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-key"></i>
                                        </div>
                                        <input name="again" type="password" class="form-control" placeholder="*Ulangi password" required>
                                    </div><!-- /.input group -->   
                                </div>
                            </div>
                        </div>  <!--./col-12-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger pull-left">Reset</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"> Tambahkan</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end dialog-->

<!-- Hapus -->
<div class="modal modal-default" id="delete_user" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Question !</h4>
            </div>
            <div class="modal-body">
                <small><?php echo $session['nama_lengkap']; ?>, yakin ingin menghapus user ini ?</small>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
                <div id="del_user"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->