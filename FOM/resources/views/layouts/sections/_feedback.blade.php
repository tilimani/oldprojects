<div tabindex="0" 
    class="feedback-container" 
    onclick="event.preventDefault();document.querySelector('#btnIssues').click();">
    <button class="feedback button1">
        <b>FEEDBACK</b>
    </button>
</div>

<section id="feedbackSection" class="d-none">
    <div class="conainer-fluid bg-light rounded">
        <div class="row">
            <div class="col-12 d-flex align-content-center justify-content-center py-3">
                <button class="button1 btnFeedFacebook" onclick = "window.location.href = ''">
                    <span class="icon-facebook pr-3"></span>
                    <b>Facebook</b>
                </button>
            </div>
            <div class="col-12 d-flex align-content-center justify-content-center">
                <button class="button1 btnFeedGmail" onclick = "window.location.href = 'mailto:hola@getvico.com'">
                    <span class="icon-google pr-3"></span>
                    <b>Gmail</b>
                </button>
            </div>
            <div class="col-12 d-flex align-content-center justify-content-center py-3">
                <button class="button1 btnFeedWhatsapp" onclick = "window.location.href = ''">
                    <span class="icon-whatsapp-black pr-3"></span>
                    <b>Whatsapp</b>
                </button>
            </div>
        </div>
    </div>
</section>