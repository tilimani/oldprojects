{{-- ISSUES MODAL--}}
<div class="modal show fade" id="issuesModal" tabindex="-1" role="dialog" aria-labelledby="issuesModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">¡Estamos trabajando en ello!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-2 col-sm-12 d-flex justify-content-around align-items-center mb-1 mx-0 p-0">
              <img class="img-fluid w-50-md" src="{{asset('images\traffic-light.png')}}" alt="Traffic light image">
            </div>
            <div class="col-md-10 col-sm-12">
              <div id="issuesAcordion">
                <div class="card-header" id="issueHeadingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link text-black" data-toggle="collapse" data-target="#issueCollpaseOne" aria-expanded="true" aria-controls="collapseOne">
                        ¿Problemas al iniciar sesión?
                      </button>
                  </h5>
                </div>
                <div id="issueCollpaseOne" class="collapse show" aria-labelledby="issueHeadingOne" data-parent="#issuesAcordion">
                  <div class="card-body">
                    <p class="font-weight-light">
                      {{--
                      <p class="lead"> --}} Esto podría ser un inconveniente de nuestros servidores, te pedimos que intentes acceder a nuestra
                        plataforma con un navegador como:
                        <u><a href="https://www.google.com/chrome/" target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">Google Chrome</a></u>,
                        <u><a href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">Mozilla Firefox</a></u> actualizado.
                      </p>
                      <p class="font-weight-light">
                        Si el problema persiste, intenta acceder en modo <u>incógnito</u>.
                        <strong><a href="https://support.google.com/chrome/answer/95464?co=GENIE.Platform%3DDesktop&hl=es" target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">(Chrome)</a></strong>
                        <strong><a href="https://support.mozilla.org/es/kb/navegacion-privada-Firefox-no-guardar-historial-navegacion " target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">(Firefox)</a></strong>
                      </p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed text-black" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                      aria-controls="collapseTwo">
                        ¿Aún no funciona?
                      </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <p class="lead">
                      {{--
                      <p class="lead"> --}} ¡No dudes en contactarnos para una asesoría personal!
                      </p>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <span class="icon-whatsapp-black pr-1"></span>
                          Whatsapp: 
                          <a href="https://wa.me/+573175750056" 
                            target="_blank"
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Mensaje directo">
                              +573175750056
                          </a>
                        </li>
                        <li class="list-group-item"><span class="icon-mail-black pr-1"><span class="path1"></span><span class="path2"></span></span>Correo:
                          <a href="mailto:contacto@friendsofmedellin.com" target="_blank" data-toggle="tooltip" data-placement="top"
                            title="Mensaje directo">hello@getvico.com</a></li>
                        <li class="list-group-item"><span class="icon-facebook-black pr-1"></span>Facebook: <a href="https://facebook.com/friendsofmedellin"
                            target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">facebook.com/friendsofmedellin</a></li>
                        <li class="list-group-item"><span class="icon-instagram-black pr-1"></span>Instagram: <a href="https://www.instagram.com/vico_vivirentreamigos/"
                            target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">@vico_vivirentreamigos</a></li>
                      </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button id="btnIssues" type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#issuesModal">
  Launch demo modal
</button>