<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" integrity="sha384-PmY9l28YgO4JwMKbTvgaS7XNZJ30MK9FAZjjzXtlqyZCqBY6X6bXIkM++IkyinN+" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <!-- ---------------------- Warrning !!! new font added - Oswald  ------------------------------ -->

    <link rel="stylesheet" href="/styles/main.css?v={{ time() }}">
    <link rel="stylesheet" href="/styles/style.css?v={{ time() }}">
    <link rel="stylesheet" href="/styles/circle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body class="{{ (!setting('extend_homepage') && @$page_data->page_type == 'home') ? 'without_content' : '' }}">

<!-- <header id="header_not_registered"></header>  -->
<header @if (Auth::check()) id="header_registred" @else id="header_not_registered" @endif
        class="@if(@$page_data->page_type != 'home') blue @endif @if (Auth::check()) registered @endif"
        @if(@$page_data->page_type == 'home') style="position: absolute;" @endif >

    <div class="head _1">
        <div class="container">
            <div class="content">
                <div class="left">
                    <div class="language">
                        <span class="language_select">RU</span>
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.984 6.453">
                                <g id="right-arrow_1_" data-name="right-arrow (1)" transform="translate(10.984 -101.478) rotate(90)">
                                    <g id="Group_12" data-name="Group 12" transform="translate(101.478)">
                                        <path id="Path_12" data-name="Path 12" class="cls-1" d="M107.756,5.063,102.868.175a.6.6,0,0,0-.85,0l-.36.36a.6.6,0,0,0,0,.85l4.1,4.1L101.653,9.6a.6.6,0,0,0,0,.85l.36.36a.6.6,0,0,0,.85,0l4.892-4.892a.606.606,0,0,0,0-.853Z" transform="translate(-101.478)"/>
                                    </g>
                                </g>
                            </svg>
                        </i>

                        <ul class="language_list">
                            @foreach(\Language::get() as $item)
                                <li class="{{ ($item->short==$lang) ? 'active' : '' }}" data-type='desktop-header'>
                                    <a href="<?=setLangUri($item->short)?>">{{ $item->short }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @php $faq = Pages::pageData('faq'); @endphp
                    <a style="text-transform: uppercase" href="{{ setUri($faq->url) }}">{{ $faq["name_$lang"] }}</a>
                </div>
                <div class="center">
                    <span>
                      <i class="location"></i>
                      MOLDOVA
                    </span>
                </div>
                <div class="right">
                    <ul>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#register">
                                <i class="user_register"></i>
                                REGISTER
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#login">
                                <i class="login_square"></i>
                                LOGIN
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="head _2">
        <div class="container">
            <div class="content">
                <div class="left">
                    <a href="/"> <img src="/img/logo.png" class="logo" alt="logo"></a>
                </div>
                <div class="center">
                    <ul>
                        <li id="licitatii_specifice"><a href="/pages/licitatii_specifice.html">LICITATII SPECIFICE</a></li>
                        <li id="licitatii_clasice"><a href="/pages/licitatii_specifice.html">LICITATII CLASICE</a></li>
                        <li id="results"><a href="/pages/results.html">
                                <svg class="analitics_result" xmlns="http://www.w3.org/2000/svg" width="24.651" height="24.651" viewBox="0 0 24.651 24.651">
                                    <g id="analytics_1_" data-name="analytics (1)" opacity="0.5">
                                        <g id="Group_54" data-name="Group 54">
                                            <g id="Group_53" data-name="Group 53">
                                                <path id="Path_65" data-name="Path 65" d="M24.17,10.051H21.088a.481.481,0,0,0-.481.481v2.431a.481.481,0,1,0,.963,0v-1.95h2.118V23.688H21.57V16.575a.481.481,0,0,0-.963,0v7.114h-.963V13.722a.481.481,0,0,0-.481-.481H16.081a.481.481,0,0,0-.481.481v9.966h-.963v-6.6a.481.481,0,0,0-.481-.481H11.074a.481.481,0,0,0-.481.481v6.6H9.629V19.855a.481.481,0,0,0-.481-.481H6.067a.481.481,0,0,0-.481.481v3.834H1.444a.482.482,0,0,1-.481-.481V1.444A.482.482,0,0,1,1.444.963H13.865V4.141A1.446,1.446,0,0,0,15.31,5.585h3.178v5.922a.481.481,0,1,0,.963,0V5.1a.482.482,0,0,0-.141-.34L14.687.141A.482.482,0,0,0,14.347,0H1.444A1.446,1.446,0,0,0,0,1.444V23.207a1.446,1.446,0,0,0,1.444,1.444H24.17a.481.481,0,0,0,.481-.481V10.532A.481.481,0,0,0,24.17,10.051ZM14.828,1.644l2.978,2.978h-2.5a.482.482,0,0,1-.481-.481ZM8.666,23.688H6.548V20.336H8.666Zm5.007,0H11.555V17.574h2.118Zm5.007,0H16.563V14.2h2.118Z" fill="#fff"/>
                                            </g>
                                        </g>
                                        <g id="Group_56" data-name="Group 56" transform="translate(20.607 14.198)">
                                            <g id="Group_55" data-name="Group 55">
                                                <path id="Path_66" data-name="Path 66" d="M428.822,295.031a.481.481,0,1,0,.141.34A.483.483,0,0,0,428.822,295.031Z" transform="translate(-428 -294.89)" fill="#fff"/>
                                            </g>
                                        </g>
                                        <g id="Group_58" data-name="Group 58" transform="translate(2.581 2.635)">
                                            <g id="Group_57" data-name="Group 57">
                                                <path id="Path_67" data-name="Path 67" d="M58.03,54.729a.481.481,0,0,0-.481.481v.866a4.428,4.428,0,1,0,4.884,4.884H63.3a.481.481,0,0,0,.481-.481A5.756,5.756,0,0,0,58.03,54.729Zm0,9.215a3.466,3.466,0,0,1-.481-6.9v3.432a.482.482,0,0,0,.481.481h3.432A3.471,3.471,0,0,1,58.03,63.944ZM58.512,60h0V55.716A4.8,4.8,0,0,1,62.793,60Z" transform="translate(-53.602 -54.729)" fill="#fff"/>
                                            </g>
                                        </g>
                                        <g id="Group_60" data-name="Group 60" transform="translate(2.6 14.167)">
                                            <g id="Group_59" data-name="Group 59">
                                                <path id="Path_68" data-name="Path 68" d="M63.678,294.25h-9.2a.481.481,0,1,0,0,.963h9.2a.481.481,0,0,0,0-.963Z" transform="translate(-54 -294.25)" fill="#fff"/>
                                            </g>
                                        </g>
                                        <g id="Group_62" data-name="Group 62" transform="translate(2.6 16.49)">
                                            <g id="Group_61" data-name="Group 61">
                                                <path id="Path_69" data-name="Path 69" d="M57.563,342.5H54.481a.481.481,0,1,0,0,.963h3.081a.481.481,0,0,0,0-.963Z" transform="translate(-54 -342.5)" fill="#fff"/>
                                            </g>
                                        </g>
                                        <g id="Group_64" data-name="Group 64" transform="translate(8.093 16.49)">
                                            <g id="Group_63" data-name="Group 63">
                                                <path id="Path_70" data-name="Path 70" d="M168.9,342.641a.481.481,0,1,0,.141.34A.485.485,0,0,0,168.9,342.641Z" transform="translate(-168.08 -342.5)" fill="#fff"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a></li>
                    </ul>
                </div>
                <div class="right"></div>
            </div>
        </div>
    </div>

    <div class="head header_mobile">
        <div class="container">
            <div class="content">
                <div class="left">
                    <div class="menu_btn">
                        <span class="fr"></span>
                        <span class="snd"></span>
                        <span class="th"></span>
                    </div>
                </div>
                <div class="center">
                    <a href="/"> <img src="/img/logo.png" class="logo" alt="logo"></a>
                </div>
                <div class="right">
                    <div class="language">
                        <span class="language_select"></span>
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.984 6.453">
                                <g id="right-arrow_1_" data-name="right-arrow (1)" transform="translate(10.984 -101.478) rotate(90)">
                                    <g id="Group_12" data-name="Group 12" transform="translate(101.478)">
                                        <path id="Path_12" data-name="Path 12" class="cls-1" d="M107.756,5.063,102.868.175a.6.6,0,0,0-.85,0l-.36.36a.6.6,0,0,0,0,.85l4.1,4.1L101.653,9.6a.6.6,0,0,0,0,.85l.36.36a.6.6,0,0,0,.85,0l4.892-4.892a.606.606,0,0,0,0-.853Z" transform="translate(-101.478)"/>
                                    </g>
                                </g>
                            </svg>
                        </i>

                        <ul class="language_list _2">
                            <li class="active" data-type="mobile-header">
                                <a href="#ro">RO</a> <!-- RO -->
                            </li>
                            <li class="" data-type="mobile-header">
                                <a href="#ru">RU</a>
                            </li>
                            <li class="" data-type="mobile-header">
                                <a href="#en">EN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu_mobile">
        <span class="close_menu"></span>

        <div class="personal_info">
            <ul>
                <li>
                    <a href="#" data-toggle="modal" data-target="#register">
                        <i class="user_register"></i>
                        REGISTER
                    </a>
                </li>
                <li>
                    <a href="#" title="Log-out" data-toggle="modal" data-target="#login">
                        <i class="login_square"></i>
                        LOGIN
                    </a>
                </li>
            </ul>
        </div>

        <div class="menu">
            <div class="country">
      <span>
       <i class="location"></i>
       MOLDOVA
     </span>
            </div>
            <div class="licitatii">
                <ul>
                    <li><a href="/pages/licitatii_specifice.html">LICITATII SPECIFICE</a></li>
                    <li><a href="/pages/licitatii_specifice.html">LICITATII CLASICE</a></li>
                    <li>
                        <a href="/pages/results.html">
                            <svg class="analitics_result" xmlns="http://www.w3.org/2000/svg" width="24.651" height="24.651" viewBox="0 0 24.651 24.651">
                                <g id="analytics_1_" data-name="analytics (1)" opacity="0.5">
                                    <g id="Group_54" data-name="Group 54">
                                        <g id="Group_53" data-name="Group 53">
                                            <path id="Path_65" data-name="Path 65" d="M24.17,10.051H21.088a.481.481,0,0,0-.481.481v2.431a.481.481,0,1,0,.963,0v-1.95h2.118V23.688H21.57V16.575a.481.481,0,0,0-.963,0v7.114h-.963V13.722a.481.481,0,0,0-.481-.481H16.081a.481.481,0,0,0-.481.481v9.966h-.963v-6.6a.481.481,0,0,0-.481-.481H11.074a.481.481,0,0,0-.481.481v6.6H9.629V19.855a.481.481,0,0,0-.481-.481H6.067a.481.481,0,0,0-.481.481v3.834H1.444a.482.482,0,0,1-.481-.481V1.444A.482.482,0,0,1,1.444.963H13.865V4.141A1.446,1.446,0,0,0,15.31,5.585h3.178v5.922a.481.481,0,1,0,.963,0V5.1a.482.482,0,0,0-.141-.34L14.687.141A.482.482,0,0,0,14.347,0H1.444A1.446,1.446,0,0,0,0,1.444V23.207a1.446,1.446,0,0,0,1.444,1.444H24.17a.481.481,0,0,0,.481-.481V10.532A.481.481,0,0,0,24.17,10.051ZM14.828,1.644l2.978,2.978h-2.5a.482.482,0,0,1-.481-.481ZM8.666,23.688H6.548V20.336H8.666Zm5.007,0H11.555V17.574h2.118Zm5.007,0H16.563V14.2h2.118Z" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="Group_56" data-name="Group 56" transform="translate(20.607 14.198)">
                                        <g id="Group_55" data-name="Group 55">
                                            <path id="Path_66" data-name="Path 66" d="M428.822,295.031a.481.481,0,1,0,.141.34A.483.483,0,0,0,428.822,295.031Z" transform="translate(-428 -294.89)" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="Group_58" data-name="Group 58" transform="translate(2.581 2.635)">
                                        <g id="Group_57" data-name="Group 57">
                                            <path id="Path_67" data-name="Path 67" d="M58.03,54.729a.481.481,0,0,0-.481.481v.866a4.428,4.428,0,1,0,4.884,4.884H63.3a.481.481,0,0,0,.481-.481A5.756,5.756,0,0,0,58.03,54.729Zm0,9.215a3.466,3.466,0,0,1-.481-6.9v3.432a.482.482,0,0,0,.481.481h3.432A3.471,3.471,0,0,1,58.03,63.944ZM58.512,60h0V55.716A4.8,4.8,0,0,1,62.793,60Z" transform="translate(-53.602 -54.729)" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="Group_60" data-name="Group 60" transform="translate(2.6 14.167)">
                                        <g id="Group_59" data-name="Group 59">
                                            <path id="Path_68" data-name="Path 68" d="M63.678,294.25h-9.2a.481.481,0,1,0,0,.963h9.2a.481.481,0,0,0,0-.963Z" transform="translate(-54 -294.25)" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="Group_62" data-name="Group 62" transform="translate(2.6 16.49)">
                                        <g id="Group_61" data-name="Group 61">
                                            <path id="Path_69" data-name="Path 69" d="M57.563,342.5H54.481a.481.481,0,1,0,0,.963h3.081a.481.481,0,0,0,0-.963Z" transform="translate(-54 -342.5)" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="Group_64" data-name="Group 64" transform="translate(8.093 16.49)">
                                        <g id="Group_63" data-name="Group 63">
                                            <path id="Path_70" data-name="Path 70" d="M168.9,342.641a.481.481,0,1,0,.141.34A.485.485,0,0,0,168.9,342.641Z" transform="translate(-168.08 -342.5)" fill="#fff"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <!-- Modal Register -->
    <div class="modal fade" id="register" role="dialog">
        <div class="modal-dialog">

            <i class="register"></i>
            <h4>CREATE NEW ACCOUNT</h4>
            <form action="">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="email" placeholder="E-mail">
                <input type="text" name="password" placeholder="Password">
                <input type="text" name="repeat_password" placeholder="Repeat password">
                <label for="terms_coditions">
                    <input type="checkbox" name="terms" id="terms_coditions">
                    <span class="check"></span>
                    @php $terms = Pages::pageData('terms'); @endphp
                    De acord cu <a target="_blank" href="{{ setUri($terms["url"]) }}">{{ $terms["name_$lang"] }}</a>
                </label>
                <button>TRIMITE</button>
                <div class="message succes">
                    <span class="title">Inregistrare reusita!</span>
                    <span class="description">Va rugam sa accesati link-ul de activare dinposta Dvs. electronica in decurs
        de 48 ore.</span>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="login" role="dialog">
        <div class="modal-dialog">

            <i class="login"></i>
            <h4>LOGIN</h4>
            <form action="">
                <input type="text" placeholder="Email">
                <input type="text" placeholder="Password">
                <a href="" class="forgot_pass"  data-dismiss="modal" data-toggle="modal" data-target="#forgot_pass">Ai uitat parola?</a>
                <button>TRIMITE</button>
                <div class="message succes">
                    <span class="title">Inregistrare reusita!</span>
                    <span class="description">Va rugam sa accesati link-ul de activare dinposta Dvs. electronica in decurs
        de 48 ore.</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="forgot_pass" role="dialog">
        <div class="modal-dialog">

            <i class="forgot_pass"></i>
            <h4>RECUPERARE PAROLA</h4>
            <form action="">
                <input type="text" placeholder="Email">
                <button>TRIMITE</button>
                <div class="message succes">
                    <span class="title">Inregistrare reusita!</span>
                    <span class="description">Va rugam sa accesati link-ul de activare dinposta Dvs. electronica in decurs
        de 48 ore.</span>
                </div>
            </form>
        </div>
    </div>

</header>

@yield('content')

<footer id="footer" style="@if(!setting('extend_homepage') && @$page_data->page_type == 'home') background-image: url('/uploads/uploads/{{ setting('home_background') }}'); @else background-image: url('/img/footer/footer.png'); @endif">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-9 col-sm-5">
                <div class="socials">
                    <a href="#"><img src="/img/footer/facebook.png" alt=""></a>
                    <a href="#"><img src="/img/footer/youtube.png" alt=""></a>
                </div>
                <p><a href="/">BlackFridayTop.com</a> este un magazine online care are menireasa va ajute sa economisiti in fiecare zi participind la licitatii pentru produse de mare interes.</p>
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach(tree(Pages::bottom()) as $menu)
                        <div class="col-md-3 col-sm-3 col-md-offset-3 col-xs-6">
                            <ul>
                                <li class="title">{{ $menu["name_$lang"] }}</li>
                                @if(!empty($menu['childs']))
                                    @foreach($menu['childs'] as $childs)
                                        <li><a href="{{ setUri($childs['url']) }}">{{ $childs["name_$lang"] }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="container">
        <div class="copyright">
            <p>Copyright <span id="year"></span></p>
            <script type="text/javascript">
                document.getElementById('year').innerHTML = new Date().getFullYear();
            </script>
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="/scripts/jquery.gallery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>

<script src="/scripts/main.js?v={{ time() }}"></script>


</body>
</html>
