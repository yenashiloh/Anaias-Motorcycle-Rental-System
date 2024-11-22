<meta
content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
name="viewport"
/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="logout-route" content="{{ route('logout') }}">
<link rel="icon" href="../../../../assets/img/logo.png" type="image/x-icon">

<!-- Fonts and icons -->
<script src="../../../../admin-assets-final/js/plugin/webfont/webfont.min.js"></script>
<script>
WebFont.load({
  google: { families: ["Public Sans:300,400,500,600,700"] },
  custom: {
    families: [
      "Font Awesome 5 Solid",
      "Font Awesome 5 Regular",
      "Font Awesome 5 Brands",
      "simple-line-icons",
    ],
    urls: ["../../../../admin-assets-final/css/fonts.min.css"],
  },
  active: function () {
    sessionStorage.fonts = true;
  },
});
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="../../../../admin-assets-final/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../../../admin-assets-final/css/plugins.min.css" />
<link rel="stylesheet" href="../../../../admin-assets-final/css/kaiadmin.min.css" />
<link rel="stylesheet" href="../../../../admin-assets-final/css/style.css" />
