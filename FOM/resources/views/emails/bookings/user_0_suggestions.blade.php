@include('emails.bookings._header')

                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top: 15px; padding-bottom: 15px;"><![endif]-->
  <div style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#434343;line-height:120%; padding-right: 15px; padding-left: 15px; padding-top: 15px; padding-bottom: 15px;">
    <div style="line-height:14px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:12px;color:#434343;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px"><span style="line-height: 28px; font-size: 24px;"><strong>🙏 {{$user->name}}, tenemos malas noticias:</strong></span></p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>


                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px;"><![endif]-->
  <div style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#7E7E7E;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px;">
    <div style="font-size:12px;line-height:14px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#7E7E7E;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="color: rgb(0, 0, 0); font-size: 16px; line-height: 19px;">Lamentablemente, tu solicitud para la habitación {{$room->number}} en {{$house->name}} ha sido rechazada. ¡Pero no te preocupes!, tenemos muchas opciones para ti en otras VICOs que se ajustan a tus características. Sabemos que alguna te van a gustar.&#160;</span></p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>

              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="600" style=" width:600px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->



<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@foreach ($suggestions as $suggestion)

<div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 15px;"><![endif]-->
  <div style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#3a3a3a;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 15px;">
    <div style="line-height:14px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:12px;color:#3a3a3a;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 21px;">@if($loop->first)<strong>Te recomendamos las siguientes VICOs:</strong>@endif</span></p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                </div>
              </div>
            <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
          </div>
        </div>
      </div>
      <div style="background-color:transparent;">
        <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
          <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
            <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#FFFFFF; width:600px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
              <div class="col num12" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
                <div style="background-color: #FFFFFF; width: 100% !important;">
                <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->


                      <div align="center" class="img-container center  autowidth  fullwidth " style="padding-right: 0px;  padding-left: 0px;">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
    <img class="center  autowidth  fullwidth" align="center" border="0" src="https://fom.imgix.net/{{$suggestion->image}}?w=750&amp;h=500&amp;fit=crop" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 600px" width="600">
  <!--[if mso]></td></tr></table><![endif]-->
  </div>



                      <div class="">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 5px;"><![endif]-->
    <div style="font-family:'Roboto', Tahoma, Verdana, Segoe, sans-serif;color:#ea960f;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 5px;">
      <div style="line-height:14px;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:#ea960f;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 21px;"><strong>{{$suggestion->name}} -&#160;</strong></span><span style="font-size: 18px; line-height: 21px;"><strong>Hab. {{$suggestion->number}}</strong></span></p></div>
    </div>
    <!--[if mso]></td></tr></table><![endif]-->
  </div>


                      <div class="">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 20px;"><![endif]-->
    <div style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#7E7E7E;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 20px;">
    <div style="font-size:12px;line-height:14px;color:#7E7E7E;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: justify">{{$suggestion->description_house}}</p></div>
    </div>
    <!--[if mso]></td></tr></table><![endif]-->
  </div>



  <div align="center" class="button-container center " style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://getvico.com/houses/{{$suggestion->house_id}}" style="height:31pt; v-text-anchor:middle; width:103pt;" arcsize="12%" strokecolor="#ea960f" fillcolor="#ea960f"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px;"><![endif]-->
    <a href="https://getvico.com/houses/{{$suggestion->house_id}}" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #ea960f; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; max-width: 138px; width: 88px;width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 25px; padding-bottom: 5px; padding-left: 25px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;mso-border-alt: none">
        <span style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:16px;line-height:32px;"><span style="font-size: 14px; line-height: 28px;">Ir a la VICO</span></span>
      </a>
    <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
  </div>



  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
      <tr style="vertical-align: top">
          <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 15px;padding-left: 15px;padding-top: 15px;padding-bottom: 15px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                  <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                      <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                  <span>&#160;</span>
                                </td>
                          </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
      </tbody>
  </table>

              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#FFFFFF; width:600px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
              <div style="background-color: #FFFFFF; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->



<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@endforeach


                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 20px; padding-bottom: 5px;"><![endif]-->
  <div style="font-family:'Roboto', Tahoma, Verdana, Segoe, sans-serif;color:#ea960f;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 20px; padding-bottom: 5px;">
    <div style="line-height:14px;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:#ea960f;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px"><span style="font-size: 24px; line-height: 28px;"><strong>¿No encontraste nada?</strong></span></p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>


                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 5px; padding-bottom: 20px;"><![endif]-->
  <div style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#7E7E7E;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 5px; padding-bottom: 20px;">
    <div style="font-size:12px;line-height:14px;color:#7E7E7E;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">Entra otra vez a getvico.com y busca más VICOs.</p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>



<div align="center" class="button-container center " style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://example.com" style="height:33pt; v-text-anchor:middle; width:129pt;" arcsize="12%" strokecolor="#ea960f" fillcolor="#ffffff"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ea960f; font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px;"><![endif]-->
    <a href="http://example.com" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ea960f; background-color: #ffffff; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; max-width: 172px; width: 122px;width: auto; border-top: 1px solid #ea960f; border-right: 1px solid #ea960f; border-bottom: 1px solid #ea960f; border-left: 1px solid #ea960f; padding-top: 5px; padding-right: 25px; padding-bottom: 5px; padding-left: 25px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;mso-border-alt: none">
      <span style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:16px;line-height:32px;"><span style="font-size: 14px; line-height: 28px;">Ir a la búsqueda</span></span>
    </a>
  <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>

@include('emails.bookings._footer',['encrypted' => $encrypted])
</body></html>
