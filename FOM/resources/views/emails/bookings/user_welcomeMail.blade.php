@include('emails.bookings._header')


                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#FFFFFF;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="line-height:14px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:12px;color:#FFFFFF;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px"><span style="font-size: 22px; line-height: 26px;">¡Bienvenidos a Medellín!</span></p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>


                        <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
      <img class="center fixedwidth" align="center" border="0" src="{{asset('images/mails/welcome/medellin/medellin_comuna13.jpg')}}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 600px" width="600">
    <!--[if mso]></td></tr></table><![endif]-->
    </div>


                  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                  </div>
                </div>
              <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
          </div>
        </div>
        <div style="background-color:#ffffff;">
          <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
              <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#ffffff;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

                  <!--[if (mso)|(IE)]><td align="center" width="600" style=" width:600px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                <div class="col num12" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
                  <div style="background-color: transparent; width: 100% !important;">
                  <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->


                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="line-height:14px;font-size:12px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;">
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <strong><span style="font-size: 16px; line-height: 19px;">¡Hola {{$user_name}}!</span></strong>
            </p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <strong><span style="font-size: 16px; line-height: 19px;">¿Cómo estás? ¡Ya empieza tu aventura!</span></strong>
            </p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">&#160;</p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <span style="font-size: 16px; line-height: 19px;"> Te queremos dar unos tips para tu llegada.</span><br>
                <span style="font-size: 16px; line-height: 19px;">Por ejemplo, el aeropuerto internacional se encuentra a una hora del centro de la ciudad, más abajo te explicamos cuál es la mejor manera para llegar a Medellín. Adicionalmente, te recomendamos ponerte en contacto con el dueño de tu VICO para que coordinen tu llegada y, adicionalmente, ¡tenemos un regalo para ti! Junto con nuestros amigos de MIEO te regalamos tu MIEO Card gratis.</span><br> <br>
                <span style="font-size: 16px; line-height: 19px;">Un abrazo,</span><br>
                <span style="font-size: 16px; line-height: 19px;">Team VICO</span><br> <br> <br><span style="font-size: 16px; line-height: 19px;">Aquí tienes los datos del dueño de tu VICO:</span>
            </p>
            <p style="margin: 0;line-height: 14px;font-size: 12px">
                <span style="font-size: 16px; line-height: 19px;">{{$manager_name}} {{$manager_lastname}}</span>
            </p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <span style="font-size: 16px; line-height: 19px;">{{$manager_phone}}</span>
            </p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <span style="font-size: 16px; line-height: 19px;">{{$manager_email}}</span>
            </p>
            <p style="margin: 0;font-size: 14px;line-height: 17px">
                <span style="font-size: 16px; line-height: 19px;">{{$house_adress}}</span>
            </p>
        </div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>



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


                        <div align="center" class="img-container center  autowidth  fullwidth " style="padding-right: 0px;  padding-left: 0px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
      <img class="center  autowidth  fullwidth" align="center" border="0" src="{{asset('images/mails/welcome/medellin/mieo_card_gift.jpg')}}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 600px" width="600">
    <!--[if mso]></td></tr></table><![endif]-->
    </div>



                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="color: rgb(234, 150, 15); font-size: 18px; line-height: 21px;"><strong><span style="line-height: 21px; font-size: 18px;">¡Obtiene tu tarjeta de descuentos gratis!</span></strong></span></p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>


                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;">
            <p style="margin: 0;font-size: 12px;line-height: 14px">
                <span style="font-size: 14px; line-height: 16px;">Por elegir tu vivienda con VICO, tienes derecho a reclamar tu MIEO Card ¡sin costo adicional!</span>
            </p>
            <p style="margin: 0;font-size: 12px;line-height: 14px">
                <span style="font-size: 14px; line-height: 16px;">¿Qué es? Es una tarjeta digital, exclusiva para los estudiantes de Medellín, y te sirve para todo el semestre.&#160;</span>
                <span style="font-size: 14px; line-height: 16px;">Con ella accedes a tres beneficios:</span><br>
                <span style="font-size: 14px; line-height: 16px;">→ Unirte a la comunidad estudiantil internacional más grande de Medellín.</span><br>
                <span style="font-size: 14px; line-height: 16px;">→ Descuentos en los eventos y viajes de MIEO Colombia</span><br>
                <span style="font-size: 14px; line-height: 16px;">→ ¡Descuentos en todos los negocios afiliados! (bares, restaurantes, marcas locales, entre otros)</span><br> <br>
                <span style="font-size: 14px; line-height: 16px;">¡Copia este código e ingrésalo en este formulario para recibir tu MIEO Card gratis!</span><br>&#160;<br>
                <span style="font-size: 14px; line-height: 16px;">¡Disfrútala durante tu semestre en Medellin!</span>
            </p>
            <p style="margin: 0;font-size: 12px;line-height: 14px">&#160;</p>
            <p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center">
                <span style="font-size: 14px; line-height: 16px;">CÓDIGO DE DESCUENTO: <span style="text-transform: uppercase; background-color: rgb(212, 212, 212); font-size: 14px; line-height: 16px;">{{str_limit($user_name, $limit = 3, $end='')}}{{str_limit($user_lastname, $limit = 3, $end='')}}{{str_limit($user_id, $limit = 2, $end='')}}{{substr($user_created_at, -2)}}</span></span>
            </p>
        </div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>



    <div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://bit.ly/consiguemieocard" style="height:30pt; v-text-anchor:middle; width:204pt;" arcsize="13%" strokecolor="#ea960f" fillcolor="#ea960f"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size:16px;"><![endif]-->
        <a href="https://bit.ly/consiguemieocard" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #ea960f; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; max-width: 272px; width: 232px;width: auto; border-top: 1px solid #ea960f; border-right: 1px solid #ea960f; border-bottom: 1px solid #ea960f; border-left: 1px solid #ea960f; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;mso-border-alt: none">
          <span style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px;line-height:19px;"><span style="font-size: 14px; line-height: 16px;"><strong><span style="line-height: 16px; font-size: 14px;">¡Reclama tu MIEO CARD gratuita!</span></strong></span></span>
        </a>
      <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
    </div>


                  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                  </div>
                </div>
              <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
          </div>
        </div>
        <div style="background-color:transparent;">
          <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid two-up ">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
              <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

                  <!--[if (mso)|(IE)]><td align="center" width="300" style=" width:300px; padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                <div class="col num6" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
                  <div style="background-color: transparent; width: 100% !important;">
                  <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 5px; padding-left: 5px;"><!--<![endif]-->


                        <div align="center" class="img-container center  autowidth  fullwidth " style="padding-right: 0px;  padding-left: 0px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
      <img class="center  autowidth  fullwidth" align="center" border="0" src="{{asset('images/mails/welcome/medellin/bus_aeropuerto.png')}}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 290px" width="290">
    <!--[if mso]></td></tr></table><![endif]-->
    </div>



                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><strong><span style="font-size: 18px; line-height: 21px; color: rgb(234, 150, 15);">Cómo llegar desde el Aeropuerto a Medellín</span></strong></p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>


                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px">Medellín posee dos aeropuertos diferentes, tu muy probablemente, llegarás al de Rionegro llamado "Jose Maria Cordoba", el cual se encuentra a casi una hora de la ciudad de Medellín. Aprenda cuál es la mejor opción para llegar a la ciudad en este articulo.</p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>



    <div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
          <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://friendsofmedellin.com/2017/07/06/las-3-mejores-maneras-para-llegar-hacia-medellin-desde-el-aeropuerto/" style="height:30pt; v-text-anchor:middle; width:204pt;" arcsize="13%" strokecolor="#ea960f" fillcolor="#ea960f"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size:16px;"><![endif]-->
            <a href="https://friendsofmedellin.com/2017/07/06/las-3-mejores-maneras-para-llegar-hacia-medellin-desde-el-aeropuerto/" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #ea960f; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; max-width: 272px; width: 232px;width: auto; border-top: 1px solid #ea960f; border-right: 1px solid #ea960f; border-bottom: 1px solid #ea960f; border-left: 1px solid #ea960f; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;mso-border-alt: none">
              <span style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px;line-height:19px;"><span style="font-size: 14px; line-height: 16px;"><strong><span style="line-height: 16px; font-size: 14px;">¿¿Cómo llegar desde el JMC?</span></strong></span></span>
            </a>
          <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
        </div>


                  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                  </div>
                </div>
                  <!--[if (mso)|(IE)]></td><td align="center" width="300" style=" width:300px; padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                <div class="col num6" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
                  <div style="background-color: transparent; width: 100% !important;">
                  <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 5px; padding-left: 5px;"><!--<![endif]-->


                        <div align="center" class="img-container center  autowidth  fullwidth " style="padding-right: 0px;  padding-left: 0px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
      <img class="center  autowidth  fullwidth" align="center" border="0" src="{{asset('images/mails/welcome/medellin/backpack.png')}}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 290px" width="290">
    <!--[if mso]></td></tr></table><![endif]-->
    </div>



                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 18px; line-height: 21px;"><strong><span style="line-height: 21px; color: rgb(234, 150, 15); font-size: 18px;">¡Que no falte en tu maleta!</span></strong></span></p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>


                        <div class="">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
      <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
        <div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px">Hemos preguntado a varios estudiantes que estuvieron el semestre pasado en Medellín cuáles cosas más les faltaron en su tiempo aquí. Hay unos tips muy útiles y sencillos, que te ayudarán a tener un tiempo aún mejor acá.</p></div>
      </div>
      <!--[if mso]></td></tr></table><![endif]-->
    </div>


    <div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://friendsofmedellin.com/2018/01/09/10-cosas-que-no-pueden-faltar-para-tu-viaje-colombia/" style="height:30pt; v-text-anchor:middle; width:204pt;" arcsize="13%" strokecolor="#ea960f" fillcolor="#ea960f"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size:16px;"><![endif]-->
        <a href="https://friendsofmedellin.com/2018/01/09/10-cosas-que-no-pueden-faltar-para-tu-viaje-colombia/" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #ea960f; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; max-width: 272px; width: 232px;width: auto; border-top: 1px solid #ea960f; border-right: 1px solid #ea960f; border-bottom: 1px solid #ea960f; border-left: 1px solid #ea960f; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;mso-border-alt: none">
          <span style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px;line-height:19px;"><span style="font-size: 14px; line-height: 16px;"><strong><span style="line-height: 16px; font-size: 14px;">¿Qué debo llevar?</span></strong></span></span>
        </a>
      <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
    </div>
                  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                  </div>
                </div>
              <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
          </div>
        </div>
    {{-- CONTENT --}}


    <div style="background-color:#ffffff;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#ffffff;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 600px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="600" style=" width:600px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->


                    <div class="" style="font-size: 16px;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif; text-align: center;"><div style="height:30px;">&nbsp;</div></div>



                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center fixedwidth" align="center" border="0" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="" title="" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 200px" width="200">
<!--[if mso]></td></tr></table><![endif]-->
</div>



                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
    <div style="font-size:14px;line-height:17px;color:#555555;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="color: rgb(85, 85, 85); font-size: 14px; line-height: 16px;">Follow us on social media:</span></p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>



<div align="center" style="padding-right: 0px; padding-left: 0px; padding-bottom: 0px;" class="">
  <div style="display: table; max-width:198px;">
  <!--[if (mso)|(IE)]><table width="198" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse; padding-right: 0px; padding-left: 0px; padding-bottom: 0px;"  align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:198px;"><tr><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 15px">
      <tbody><tr style="vertical-align: top"><td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://facebook.com/vico.vivirentreamigos" title="Facebook" target="_blank">
          <img src="{{asset('images/mails/facebook@2x.png')}}" alt="Facebook" title="Facebook" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      <div style="line-height:5px;font-size:1px">&#160;</div>
      </td></tr>
    </tbody></table>
      <!--[if (mso)|(IE)]></td><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 15px">
      <tbody><tr style="vertical-align: top"><td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://getvico.com/" title="website" target="_blank">
          <img src="{{asset('images/mails/website@2x.png')}}" alt="website" title="website" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      <div style="line-height:5px;font-size:1px">&#160;</div>
      </td></tr>
    </tbody></table>
      <!--[if (mso)|(IE)]></td><td width="32" style="width:32px; padding-right: 15px;" valign="top"><![endif]-->
    <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 0">
      <tbody><tr style="vertical-align: top"><td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <a href="https://instagram.com/vico_vivirentreamigos" title="Instagram" target="_blank">
          <img src="{{asset('images/mails/instagram@2x.png')}}" alt="Instagram" title="Instagram" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
        </a>
      <div style="line-height:5px;font-size:1px">&#160;</div>
      </td></tr>
    </tbody></table>
    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
  </div>
</div>


                    <div class="" style="font-size: 16px;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif; text-align: center;"><div style="margin-top: 20px;border-top:1px dashed #D6D6D6;margin-bottom: 20px;"></div></div>



                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#c0c0c0;line-height:120%;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
    <div style="font-size:14px;line-height:17px;color:#c0c0c0;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">Centro de Desarrollo Empresarial<br>Universidad Pontificia Bolivariana<br>Circular 1 #70 - 01<br>Medellín.<br><br>VICO Company © All rights reserved.</p></div>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>


                    <div class="" style="font-size: 16px;font-family:'Quattrocento', 'Trebuchet MS', Helvetica, sans-serif; text-align: center;"><p style="font-size: 14px; color: #c0c0c0;padding-top:5px; padding-bottom:5px">Made with <img width="18px" src="{{asset('images/mails/colombia_heart.png')}}"> &amp; <img width="18px" src="{{asset('images/mails/germany_heart.png')}}"> in Medellín.</p></div>


              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    </td>
  </tr>
  </tbody>
  </table>
  <!--[if (mso)|(IE)]></div><![endif]-->


</body></html>
