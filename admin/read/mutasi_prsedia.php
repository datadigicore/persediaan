<form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
  <input type="hidden" name="manage" value="mutasi">
  <div class="box-body">
    <label class="col-sm-3 control-label">Kode Satker</label>
    <div class="col-sm-8">
      <select name="satker" id="satker" class="form-control select2">
      </select>
    </div>
  </div>
  <div class="box-body" id="awal">
    <label class="col-sm-3 control-label">Tanggal Awal</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="" required>
    </div>
  </div>   
  <div class="box-body" id="akhir">
    <label class="col-sm-3 control-label">Tanggal Akhir</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="" required>
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
  <div class="box-footer">
    <button type="submit" class="btn btn-info pull-right">Submit</button>
  </div> 
</form>