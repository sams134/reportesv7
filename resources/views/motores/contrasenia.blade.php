<!DOCTYPE html>
<link href="{{$server}}vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .titulos {
    position: absolute;
    font-family: Arial, Helvetica, sans-serif;
  }
  .supertitle
  {
      top: 35px;
      font-size: 34px;
      left:20px;
      font-weight: bold;
      color: #bdd3e9;
      width: 100%;
  }
  .supersubtitle
  {
      top: 75px;
      font-size: 20px;
      left:20px;
      font-weight: 100;
      color: #bdd3e9;
  }
  .title1{
      top: 150px;
      font-size: 25px;
      text-decoration: underline;
      left:20px;
      font-weight: 100;
      color: #fff;
    
  }
  .title2{
      top: 165px;
      font-size: 20;
      left:20px;
      font-weight: 100;
      color: #fff;
  }
  
 .os{
     top: 160px;
     left:455px;
     font-size: 30px;
     font-weight: bold;
     color: #fff;
     text-transform: uppercase;
 }
 .cliente{
     top: 195px;
     left:455px;
     width:400px;
     font-size: 19px;         
     color: #fff;
     text-transform: uppercase;
 }
 #placa {
  position: absolute;
  top:270px;
  width: 100%;
 }
 .title3{
    top:230px;
    
    font-weight: bolder;
    color: #0070c0; 
 }
 .comentarios-cliente{
     position: absolute;
     
     width:600px;
     height: 40px;
     top:415;
     left:240;
     font-size: 10px;
     padding:5px;
     overflow: auto;
 }
 .footer {
     top:1061;
 }
 .footer-text
 {
    top:1270;
    font-size: 12;
    left:485;
    color:#fff;
 }
 .check{
     border: 1px solid #444;
     width:25;
     margin-bottom:5px;
 }
</style>

<div id="heading">
<img src="{{$server}}img/prueba3.png" style="max-width:920px;position:absolute;top:0px">
</div>
<div id="clinica" >
  <p class="supertitle titulos">CLINICA DE MOTORES ELECTRICOS </p>
  <p class="supersubtitle titulos"> ORDEN DE SERVICIO</p>
  <p class="title1 titulos" >RECEPCION DE EQUIPO</p>
  
  <p class="os titulos"> {!!$motor->year!!}-{!!$motor->os!!}</p>
  <p class="cliente titulos"> {!!$motor->cliente->cliente!!}</p>
</div>
<div id="placa">
  <p class="title3 titulos" style="font-size:25px;top:-40px;width:100%">DATOS DE PLACA</p>
  <table class="table table-hover titulos" style="font-size:12px;top:270">
          <tr>
                  <td class="active"> Marca </td>
                  <td class="text-capitalize"> {!!$motor->marca!!}
                  <td class="active"> Serie </td>
                  <td class="text-uppercase"> {!!$motor->serie!!}
                  <td class="active"> Modelo </td>
                  <td class="text-uppercase"> {!!$motor->modelo!!}
          </tr>
          <tr>
                  <td class="active"> Potencia </td>
                  <td>
                              @if($motor->infoMotor != null)
                              {!!$motor->infoMotor->reales == 1?"&asymp;":""!!}
                            @endif
                            {!!$motor->hp!!} 
                            {!!$motor->hpkw==1?"KW":"HP"!!} 
                  </td>
                  <td class="active"> Volts </td>
                  <td> {!!$motor->volts!!}
                  <td class="active"> Amps </td>
                  <td> {!!$motor->amps!!}
          </tr>
          <tr>
                  <td class="active"> Rpm </td>
                  <td> {!!$motor->rpm!!} 
                  <td class="active"> Factor de Potencia </td>
                  <td> {!!$motor->pf!!}
                  <td class="active"> Efficiencia </td>
                  <td> {!!$motor->eff!!}
          </tr>
          <tr>
                  <td class="active"> Hz. </td>
                  <td> {!!$motor->hz!!} 
                  <td class="active"> Frame </td>
                  <td class="text-uppercase"> {!!$motor->frame!!}
                  <td class="active">Enclosure  </td>
                  <td> {!!$motor->id_encl!!}
          </tr>
      </table>
      <p class="title3 titulos" style="font-size:16;top:420">COMENTARIOS DE CLIENTE:</p>
      <div id="comentarios" class="comentarios-cliente"> 
                {!!$motor->comentarios!!}
      </div>
</div>