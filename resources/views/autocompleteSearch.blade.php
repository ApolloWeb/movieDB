<!DOCTYPE html>
<html>
<head>
    <title>How to Autocomplete Search using Typeahead JS in Laravel 9 - LaravelTuts.com</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
          .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
	border: none;
  background: transparent;
	color: #fff;
  margin: 0;
}

.ui-menu-item:hover {
  font-weight: bold;
}
          </style>
</head>
<body>
     
<div class="container mt-5">
    <h3 class="mb-5 text-center">Movie Search</h3>   
    <strong>Search Movie:</strong>
    <div id="scrollable-dropdown-menu">
        <input class="typeahead form-control" id="tags" type="text" placeholder="Name" nmae="name">
    </div>
    <div class="row mt-5">
      <div class="col-3">
        <img id="poster" class="img-fluid" />
      </div>
      <div class="col-9">
        <h1 id="title"></h1>
      </div>
    </div>
</div>
<script>
    var path = "{{ route('autocomplete') }}";
    $( function() { 
    $( "#tags" ).autocomplete({
      source: path,
      minLength: 2,
      select: function( event, ui ) {
        $("#title").text(ui.item.label);
        $("#poster").attr('src', ui.item.poster_path);
      }
    }).data("ui-autocomplete")._renderItem = function( ul, item ) {
    return $( "<li class='ui-autocomplete-row'></li>" )
        .data( "item.autocomplete", item )
        .append( item.img + item.label )
        .appendTo( ul );
    };
  } );
  
</script>
     
</body>
</html>