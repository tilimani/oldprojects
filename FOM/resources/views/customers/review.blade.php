@extends('customers.index')
@section('title', 'review')
@section('contentReview')
<form method="POST">

</form>
<div class="main-container">
    <div class="col-md-7">
        <div class="row">
            <h3 class="text-center rev-tittle">{{trans('general.leave_review')}}</h3>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.how_was_vico_experience')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <h3 class="text-center rev-tittle">{{trans('general.the_house')}}</h3>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.info_correct')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.cleanliness')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.kitchen_stuff')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.was_wifi_good')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.enough_bathrooms')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.how_were_roomies')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <h3 class="text-center rev-tittle">{{trans('general.the_room')}}</h3>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.how_much_did_like')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.was_it_loud')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <h3 class="text-center rev-tittle">{{trans('general.the_owner')}}</h3>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.owner_communication')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>{{trans('general.promise')}}</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center rev-tittle">The area</h3>
        </div>
        <hr>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>General: Que tal es el area para vivir?</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>Transporte: Tenías todo el acceso a transporte público que necesitabas?</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <div class="row rev-question">
            <div class="col-md-6 rev-content">
                <p>Hacer Compras: Tenías acceso a tiendas/supermercados cerca?</p>
            </div>
            <div class="col-md-6">
                <div class="review-container">
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                <button class="star"><span class="stararea">★</span></button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row rev-question">
            <h3 class="text-center rev-tittle">How'd you rate the house between quietly and loud? (party)</h3>
            <div class="col-md-12 ">
                <input type="range" id="myRange" min="1" max="5" value="3" class="sliderCustom">
                <div class="footer-nav-container text-center">
                    <span class="footer-item text-left">Least</span>
                    <span class="footer-item text-center" id="demo"></span>
                    <span class="footer-item text-right">Most</span>
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center rev-tittle">Leave a comment below:</h3>
            <label class="text-left"><h4>Describe your experience and stay</h4></label>
            <label class="rev-content">
                What did you really like? What didn't like? What was a nice story? Do you have recommendations?
            </label>
        </div>
        <div class="row">
            <textarea>
             </textarea>
        </div>
        <div class="row">
            <label class="text-left rev-tittle"><h4>Private message for your host</h4></label>
            <label class="rev-content">
                What did you really like? What didn't like? What was a nice story? Do you have recommendations?
            </label>
        </div>
        <div class="row">
            <textarea>
             </textarea>
        </div>
        <div class="col-md-12 recomend">
            <div class="col-md-6">
                <h4>Would you recommend the VICO?</h4>
            </div>
            <div class="col-md-6">
                <div class="col-md-3">
                   {{-- DISLIKE BUTTON  --}}
                  <div class="dislike">
                    <i class="fa fa-thumbs-down"></i>
                  </div>
                </div>
                <div class="col-md-3">
                   {{-- LIKE BUTTON  --}}
                  <div class="like">
                    <i class="fa fa-thumbs-up"></i>
                  </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
             {{-- SUBMIT BUTTON --}}
            <a href="{{'/review/fom/'.$user[0]->id}}" ><button class="submit"><span>Submit</span></button></a>
        </div>
    </div>
    <div class="col-md-5">
        <figure class="image-holder">
            <img src="{{'http://fom.imgix.net/'.$image_house->image}}" class="img-responsive" alt="Responsive image"/>
            <figcaption>
                <h4>{{$house[0]->name}}</h4>
            </figcaption>
        </figure>
    </div>
</div>
<script type="text/javascript">
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function(){
        output.innerHTML = this.value;
    }
</script>
@endsection
