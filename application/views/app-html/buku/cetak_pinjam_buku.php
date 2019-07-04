<html>
 <head></head>
 <body onload="window.print()"> <!--  onload="window.print()" -->
   <div class="wrapper">
      <div class="header">
         <div class="big-title">Peminjaman Buku Tanah</div>
      </div>
   </div>
   <div class="content">
                        <table>
                          <tr>
                            <td class="doc-label">Jenis Hak</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td><?php echo $this->bpn->hak($data->id_hak) ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">No Hak</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td><?php echo $data->no_hakbuku; ?></td>
                          </tr>
                          <?php if($data->id_hak != 5) : ?>
                              <tr>
                                <td class="doc-label">Kecamatan</td>
                                <td width="20px" style="text-align: center;">:</td>
                                <td> <?php echo $this->bpn->kecamatan($data->id_kecamatan) ?></td>
                              </tr>
                              <tr>
                                <td class="doc-label">Desa/Kel </td>
                                <td width="20px" style="text-align: center;">:</td>
                                <td> <?php echo $this->bpn->desa($data->id_desa) ?></td>
                              </tr>
                          <?php endif; ?>
                          <tr>
                            <td class="doc-label">No. 208</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td><?php echo $data->no208; ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Tahun</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td><?php echo $data->tahun; ?></td>
                          </tr>
                                <tr>
                                  <td class="doc-label"><?php echo ($data->id_hak==5) ? 'Nilai' : 'Luas'; ?> </td>
                                  <td width="20px" style="text-align: center;">:</td>
                                  <td><?php echo $data->luas; ?> </td>
                                </tr>
                          <tr>
                            <td class="doc-label">Tanggal Peminjaman</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td><?php echo tgl_indo($data->tgl_peminjaman); ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Kegiatan</td>
                            <td width="20px" style="text-align: center;">:</td>
                            <td> <?php echo $data->kegiatan; ?></td>
                          </tr>
                        </table>

                        <table style="margin-top: 70px; width: 100%;">
                          <tr>
                            <td width="30%" style="text-align: center;">Pengeluar</td>
                            <td width="40%"></td>
                            <td width="30%" style="text-align: center;">Peminjam</td>
                          </tr>
                          <tr>
                            <td><div style="margin-bottom: 50px;"></div></td>
                          </tr>
                          <tr>
                            <td style="text-align: center;"><?php echo $data->nama_lengkap; ?></td>
                            <td></td>
                            <td style="text-align: center;"><?php echo $data->peminjam; ?></td>
                          </tr>
                        </table>
   </div>
 </body>
</html> 

<style>
   table { font-size:12px; font-family:'Arial'; }
   .header { width:100%; height:10%; text-align:center; font-weight:500;  }
   .big-title {  font-family:'Arial'; font-size:14px; letter-spacing:normal; font-weight:bold; }
   .small-title {  font-family:'Times New Roman'; font-size:13px; letter-spacing:normal; }
   .content { font-size:12px; font-family:'Arial'; margin-top:-20px;}
   .upper { text-transform: uppercase;  }
   .underline { text-decoration: underline; }
   .bold { font-weight:bold; }
   table.gridtable {
      border-width: 1px;
      border-color: black;
      border-collapse: collapse; 
      font-size:0.8em;
   }
   table.gridtable th {
      border-width: 1px;
      padding: 5px;
      border-style: solid;
      border-color: black;
   }
   table.gridtable td {
      border-width: 1px;
      border-top: 0px;
      padding: 0px 0px 0px 3px;
      border-style: solid;
      border-color: black;
   }
</style>

