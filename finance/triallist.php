
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div align="right"><font size="4"><b>Statement</font></b> </div>
<hr />
<div><table id="report" style="font-size:12px;padding:10px;">
<tr><td>Account Name: &nbsp; <b>'.$statementRecevee.' </b>&nbsp;&nbsp;&nbsp; Tel No : '.$debtelno.'</td></tr>
<tr><td>Sabil No: &nbsp; '.strtoupper($sabil[$s]).'&nbsp;&nbsp; House No.&nbsp;'.ucfirst($hseno).'</td><td style="text-align:Center">  </td></tr>
<tr><td style="text-align: right">From:&nbsp; <b>'.$from_date.'</b>&nbsp; to &nbsp;<b>'.$to_date.'</b></td></tr>
</table></div>
<hr />


<table id="statements" style="font-size:12px;" >
<thead><tr><th style="width: 60px" colspan="2"> Date</th><th colspan="2"> Narration</th><th style="text-align: center;">Debit</th> <th style="text-align: center;"> Credit</th> <th style="text-align: center;"> Balance</th></tr></thead>
<tbody>';
       
                  
          <tr><td colspan='17'><b>".$indata[$k]['accname']."</b></td></tr>
          
                     <tr><td colspan='5' style='width:300px;text-align:center;font-size:14px'><b>Opening Bal</b></td><td></td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>

                 <tr><td colspan='5' style='width:300px;text-align:center;font-size:14px'><b>B/F</b></td><td></td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>
                
                           <tr><td style='font-size:12px;' colspan ='2'>".date('d-m-Y', strtotime($q[$l]['date']))."</td><td style='font-size:12px;' colspan='2'>".$doctype." No&nbsp:&nbsp;&nbsp;".$q[$l]['docno']." - $accnme    ".$q[$l]['pmode']."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".$debitamt."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".$creditamt."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>

              <tr><td colspan=4 style="text-align: center">'.$indata[$k]['accname'].' Balance</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($drbal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($crbal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($balance_bf,2).'</td></tr>
              <td colspan=7><br></td>';
<tr><td colspan=4>Totals</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($dbtotal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($crdtotal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($balnce,2).'</td></tr>

</tbody>
<tfoot>
         <tr><td style="border-top: 3px solid #000" colspan="7"><h7>Please check your balance and bring any discrepancies within 15 days</h7>
         <span align="left" style="font-size:x-small;"><br>Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span></td> </tr></tfoot></table><br />

</body>
</html>


 