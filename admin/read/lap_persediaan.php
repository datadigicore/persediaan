<form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
  <input type="hidden" name="manage" value="lap_persediaan">  
  <div class="box-body">
    <label class="col-sm-3 control-label">Kode Satker</label>
    <div class="col-sm-8">
      <select name="satker" id="satker" class="form-control select2">
      <option value="">-- Pilih Kode Satker --</option>
      </select>
    </div>
  </div> 
  <div class="box-body">
    <label class="col-sm-3 control-label">Format laporan</label>
    <div class="col-sm-8">
      <select name="format" id="format" class="form-control">
        <option value="pdf">PDF</option>
        <option value="excel">Excel</option>
      </select>
    </div>
  </div>                    
  <div class="box-body radio">
      <div class="col-md-3"></div>
      <div class="col-md-8">
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="tanggal" value="tanggal">S/d Tanggal</label>
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="semester" value="semester">Semester</label>
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="tahun" value="tahun" checked>Tahun <?php echo $_SESSION['thn_ang'];?></label>
      </div>
  </div>                                       
  <div class="box-body" id="akhir"  style="display: none;">
    <label class="col-sm-3 control-label">S/d Tanggal</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="">
    </div>
  </div> 
  <div class="box-body" id="bln"  style="display: none;">
    <label class="col-sm-3 control-label">Semester</label>
    <div class="col-sm-3">
      <select name="smt" id="smt" class="form-control">
        <option value="01-06">Semester 1</option>
        <option value="07-12">Semester 2</option>
      </select>
    </div>
  </div> 
  <div class="box-footer">
    <button type="submit" class="btn btn-info pull-right">Submit</button>
  </div>
</form>
