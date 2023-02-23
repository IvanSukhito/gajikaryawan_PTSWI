<?php


if ( !function_exists('form_tunjangan')) {
    /**
     * @param $ms_kegiatan
     * @param $listJenjangPerancang
     * @param $jenjangPerancangId
     * @return string
     * @throws Throwable
     */
    function form_tunjangan() {

       

        $html = '<table class="table table-tunjtetap table-bordered table-striped">
        <thead>
        <tr>
        <th width="60%" colspan="5">'.__('general.butir_kegiatan').'</th>
        <th width="15%" class="text-center">Nilai</th>
        <th width="10%" class="text-center">Satuan</th>
        <th width="15%" class="text-center">Status</th>
        </tr>
        </thead>
        <tbody>
        ';

    
        $html .= '<tr class="all-row tunjtetap-1 jen-0" style="">
        <td colspan="5">Gaji Pokok</td>
        <td width="15%">&nbsp;</td>
        <td width="10%" class="text-center"></td>
        <td width="15%" class="text-center"></td>
        </tr>';
        $html .= render_table_tunjangan();
        $html .= '</tbody></table>';

        return $html;
    }


}

if ( !function_exists('render_table_tunjangan')) {
    /**
     * @param $ms_kegiatan
     * @param $listJenjangPerancang
     * @param $jenjangPerancangId
     * @return string
     * @throws Throwable
     */
    function render_table_tunjangan() {

       $arrayTunjanganTetap = ['basic_salary','tunj_jabatan'];
       $arrayisiTunjTetap = [];
       $arrayTunjanganTakTetap = ['tunj_kerajinan','tunj_shift','tunj_kehadiran','tunj_transport','tunj_bonus_prod'];

       $html = '<tr class="all-row tunjtetap-1 tunjtetap-2 jen-0" style=""><td width="1%">&nbsp;</td>
       <td colspan="4"><b>1.Tunjangan Upah Tetap</b></td>
       <td width="15%">&nbsp;</td>
       <td width="10%" class="text-center"></td>
       <td width="15%" class="text-center"></td>
       </tr>';
       foreach($arrayTunjanganTetap as $listUpahTetap){
        $html .= '
        <tr class="all-row tunjtetap-1 tunjtetap-2 tunjtetap-3 jen-4" style=""><td width="1%">&nbsp;</td><td width="1%">&nbsp;</td>
        <td colspan="3">'.$listUpahTetap.'</td>
        <td width="15%" class="text-center"><input type="text" name="'.$listUpahTetap.'" class="form-control " value="1" readonly></td>
        <td width="10%" class="text-center">Decimal</td>
        <td width="15%" class="text-center">Upah Tetap</td>
        </tr>';
       }
    //    foreach($arrayTunjanganTakTetap as $listUpahTakTetap){

    //    }
    //     $html .= '';

        return $html;
    }

    
}
?>