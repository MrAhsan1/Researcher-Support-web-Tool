@extends('About.team')
@section('team')
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  html 
  {
    box-sizing: border-box;
  }

  *, *:before, *:after {
    box-sizing: inherit;
  }

  .column {
    float: left;
    width: 25%;
    margin-bottom: 16px;
    padding: 0 8px;
  }

  @media screen and (max-width: 650px) {
    .column {
      width: 100%;
      display: block;
    }
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  }

  .containes {
    padding: 0 16px;
  }

  .containes::after, .row::after {
    content: "";
    clear: both;
    display: table;
  }

  .title {
    color: grey;
  }

</style>
</head>
<body>

    <div class="container">
          <div class="commontop text-left">
            <h2 >Meet Our Team</h2>
          </div>

        <div class="row">
          <div class="column">
            <div class="card">
              <img src="images/inzi.jpg" alt="Ahsan" style="width:100%">
              <div class="containes">
                <h2>Inzamam Idrees</h2>
                <p class="title">Developer & Designer</p>
                <p>I am full stack android and laravel developer.</p>
                <p>inzamam.idrees.057@gmail.com</p>
                <div class="social">
                  <div class="container">
                    <div class="row">
                        <ul class="list-inline">
                          <li>
                            <a href="https://www.facebook.com/inzi.smart" target="_blank"><i class="icofont icofont-social-facebook"></i></a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/u/0/110334217557332215925" target="_blank"><i class="icofont icofont-social-google-plus"></i></a>
                          </li>
                          <li>
                            <a href="https://www.instagram.com/smart_inzi/" target="_blank"><i class="icofont icofont-social-instagram"></i></a>
                          </li>
                          <li>
                            <a href="https://www.linkedin.com/in/inzamam-idrees-033364124/" target="_blank"><i class="icofont icofont-social-linkedin"></i></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="column">
            <div class="card">
              <img src="images/ahsan.jpg" alt="Ahsan" style="width:100%">
              <div class="containes">
                <h2>Ahsan Ayoub</h2>
                <p class="title">Developer & Designer</p>
                <p>I am full stack android and laravel developer.</p>
                <p>ahsanayoub2017@gmail.com</p>
                <div class="social">
                  <div class="container">
                    <div class="row">
                        <ul class="list-inline">
                          <li>
                            <a href="https://www.facebook.com/mrperfect.ahsan" target="_blank"><i class="icofont icofont-social-facebook"></i></a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/u/0/102093692194878217622" target="_blank"><i class="icofont icofont-social-google-plus"></i></a>
                          </li>
                          <li>
                            <a href="https://www.instagram.com/mrperfect_ahsan/?hl=en" target="_blank"><i class="icofont icofont-social-instagram"></i></a>
                          </li>
                          <li>
                            <a href="https://www.linkedin.com/in/ahsanayoub/" target="_blank"><i class="icofont icofont-social-linkedin"></i></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="column">
            <div class="card">
              <img src="images/faisal.jpeg" alt="Ahsan" style="width:100%">
              <div class="containes">
                <h2>Faisal Mehmood</h2>
                <p class="title">Developer & Designer</p>
                <p>I am full stack android and laravel developer.</p>
                <p>faisalmehmood5544@gmail.com</p>
                <div class="social">
                  <div class="container">
                    <div class="row">
                        <ul class="list-inline">
                          <li>
                            <a href="https://www.facebook.com/profile.php?id=100008986369313" target="_blank"><i class="icofont icofont-social-facebook"></i></a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/u/0/100888007226865996349" target="_blank"><i class="icofont icofont-social-google-plus"></i></a>
                          </li>
                          <li>
                            <a href="https://www.instagram.com/faisalmehmood5544/" target="_blank"><i class="icofont icofont-social-instagram"></i></a>
                          </li>
                          <li>
                            <a href="https://www.linkedin.com/" target="_blank"><i class="icofont icofont-social-linkedin"></i></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


          <div class="column">
            <div class="card">
              <img src="images/shahzaib.jpeg" alt="Ahsan" style="width:100%">
              <div class="containes">
                <h2>Shahzaib Ishrat</h2>
                <p class="title">Developer & Designer</p>
                <p>I am full stack android and laravel developer.</p>
                <p>shahzaibajwa71@gmail.com</p>
                <div class="social">
                  <div class="container">
                    <div class="row">
                        <ul class="list-inline">
                          <li>
                            <a href="https://www.facebook.com/shahzaib.bajwa.31" target="_blank"><i class="icofont icofont-social-facebook"></i></a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/u/0/110947567805817571003" target="_blank"><i class="icofont icofont-social-google-plus"></i></a>
                          </li>
                          <li>
                            <a href="https://www.instagram.com/shahzaib.ishrat/" target="_blank"><i class="icofont icofont-social-instagram"></i></a>
                          </li>
                          <li>
                            <a href="https://www.linkedin.com/in/shahzaib-ishrat-60256713b/" target="_blank"><i class="icofont icofont-social-linkedin"></i></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

         

        </div>

</div>


<!-- space start here -->
<div class="space">
  <div class="container">
     
  </div>
</div>
<div class="space">
  <div class="container">
  </div>
</div>
<div class="space">
  <div class="container">
  </div>
</div>
<!-- space end here -->



</body>
</html>
@endsection()