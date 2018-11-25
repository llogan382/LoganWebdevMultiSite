<?php get_header( );?>

<div id="columns" class="card-columns">
  <div class="card text-center">
    <img class="card-img-top" src="/public_html/wp-content/themes/loganwebdev/img/southeast.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Where can we find you?</h5>
      <p class="card-text">Add a map to your new site.</p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#map_modal">
        See how it works.
      </button>
    </div>
  </div>
  <div class="card p-3">
  <img class="card-img-top" src="/public_html/wp-content/themes/loganwebdev/img/adult-group.jpg" alt="Card image cap">
      <p>Who am I missing?</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Potential clients found <cite title="Source Title">Everywhere</cite>
        </small>
      </footer>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#people_modal">
        Learn more. 
      </button>
  </div>
  <div class="card text-center">
    <img class="card-img-top" src="/public_html/wp-content/themes/loganwebdev/img/calendar-example.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Add a calendar.</h5>
      <p class="card-text">Let people know about sales. And events.</p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cal_modal">
        Check it out. 
      </button>
    </div>
  </div>
  <div class="card text-center">
  <img class="card-img-top"  src="/public_html/wp-content/themes/loganwebdev/img/logos.png" alt="Card image">    
    <div class="card-body">
      <h5 class="card-title">Get social. </h5>
      <p class="card-text">Be where your clients are.</p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#social_modal">
        How easy is it?
      </button>
    </div>
  </div>
  <div class="card text-center">
    <div class="card-body">
    <img class="card-img-top" src="/public_html/wp-content/themes/loganwebdev/img/analytics.png" alt="Card image cap">
      <h5 class="card-title">Add analytics.</h5>
      <p class="card-text">Keep track of who comes. And who goes.</p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#analytics_modal">
        Tell me more.
      </button>
    </div>
  </div>

  <div class="card text-center">
  <img class="card-img-top"  src="/public_html/wp-content/themes/loganwebdev/img/gravity-forms.png" alt="Card image">
    <div class="card-body">
      <h5 class="card-title">Intuitive forms. </h5>
      <p class="card-text">Interact with your clients. </p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forms_modal">
        How do they work?
      </button>
    </div>
  </div>
    <div class="card text-center">
    <iframe class="card-img-top" src="https://www.youtube.com/embed/g0M4vkfCoWM?rel=0&amp;autoplay=1&amp;autoplay=0&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>  
    <div class="card-body">
      <h5 class="card-title">Add videos.  </h5>
      <p class="card-text">Bring things to lfe.  </p>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vid_modal">
        How does it work?
      </button>
    </div>
  </div>

  <div class="card text-center">
    <div class="card-body">
    <img class="card-img-top" src="/public_html/wp-content/themes/loganwebdev/img/email.png" alt="Card image cap">
      <h5 class="card-title">How do I start?</h5>
      <p class="card-text">Let's talk about you.</p>
      <a class="btn btn-primary" href="mailto:llogan382@gmail.com?subject=Need%20a%20website" role="button">What can I expect?</a>
    </div>
  </div>
</div>

</div>

<?php include_once("partials/map-modal.php");?>
<?php include_once("partials/Calendar-modal.php");?>
<?php include_once("partials/social-modal.php");?>
<?php include_once("partials/video-modal.php");?>
<?php include_once("partials/people-modal.php");?>
<?php include_once("partials/contact-modal.php");?>
<?php include_once("partials/forms-modal.php");?>
<?php include_once("partials/analytics-modal.php");?>






