/*
 * GMapEZ -- Turn specially-marked HTML into Google Maps
 * Copyright (C) July 2005 by Chris Houser <chouser@bluweb.com>
 *
 * This code is licensed under the GNU General Public License (GPL)
 *
 * If you use this code on a web page, please include on that page a
 * link to http://bluweb.com/chouser/gmapez/ -- this is a request, not
 * a requirement.  Thanks.
 */
(function(){
  var startdate = new Date();

  document.write( [
    '<style type="text/css">',
    'div.GMapEZ {',
    '  display: none;',
    '  border: 1px #888 solid;',
    '}',

    'div.GMapEZ ul.warnings {',
    '  position: absolute;',
    '  top: 0;',
    '  left: 0;',
    '  margin: 0;',
    '  padding-right: 0.5em;',
    '  padding-left: 1.5em;',
    '  display: none;',
    '  border: 1px #888 solid;',
    '  background: #fff;',
    '  z-index: 100000000;',
    '  text-align: left;',
    '  font-family: Arial;',
    '  font-size: 9pt;',
    '  overflow: auto;',
    '}',

    'div.GMapEZ button.warnings {',
    '  display: block;',
    '  position: absolute;',
    '  z-index: 100000000;',
    '  bottom: 20px;',
    '  right: 0;',
    '  color: #f00;',
    '}',

    'v\\:* {',
    '  behavior:url(#default#VML);',
    '}',
    '</style>'
  ].join('\n'));

  function loadfunc() {

    if( ! window.GIcon ) {
      if( ! GMapsNamespace )
        return;
      _apiHash = undefined;
      GMapsNamespace();
    }

    if( ! GBrowserIsCompatible() && _apiHash !== undefined ) {
      if( document.getElementsByTagName ) {
        // Find all divs marked as GMapEZ
        var divs = document.getElementsByTagName( 'div' );
        for( var i = 0; i < divs.length; ++i ) {
          var div = divs[ i ];
          if( div.className.indexOf( 'GMapEZ' ) > -1 ) {
            div.innerHTML =  [
              'Your browser is not capable of displaying this Google',
              'Map. Try using',
              '<a href="http://getfirefox.com/">Firefox</a>.'
              ].join('\n');
            div.style.display = 'block';
            div.style.padding = '0.3em';
            div.style.background = '#eee';
            div.style.overflow = 'auto';
          }
        }
      }
      else {
        alert( [
          'Your browser is not capable of displaying',
          'Google Maps on this page. Try using Firefox:',
          'http://getfirefox.com/' ].join('\n') );
      }
      return;
    }

    function GSmallMapTypeControl() {
      GMapTypeControl.call( this, true );
    }
    GSmallMapTypeControl.prototype = new GMapTypeControl();
    GSmallMapTypeControl.prototype.constructor = GSmallMapTypeControl;
    window.GSmallMapTypeControl = GSmallMapTypeControl;

    var CtrlTable = {
      'GLargeMapControl': true,
      'GSmallMapControl': true,
      'GSmallZoomControl': true,
      'GSmallMapTypeControl': true,
      'GMapTypeControl': true,
      'GScaleControl': true
    };

    var MapTypeTable = {
      'G_MAP_TYPE' : true,
      'G_SATELLITE_TYPE' : true,
      'G_HYBRID_TYPE' : true,
      'G_KATRINA_TYPE' : true
    };

    var idmarkers = {};
    function markerForUrl( url ) {
      var matcha = /#(.*)/.exec( url );
      if( matcha )
        return idmarkers[ matcha[ 1 ] ];
      else
        return null;
    }

    function wordMap( str ) {
      var wmap = {};
      var list = str.split(' ');
      for( var j = 0; j < list.length; ++j ) {
        wmap[ list[ j ] ] = true;
      }
      return wmap;
    }

    var defaultIcon = (new GMarker()).icon;

    var markerOpener = {
      markers: [],
      addMarker: function( marker ) {
        this.markers.push( marker );
      },
      chainOpen: function( i ) {
        /*
         * This is a work-around for a Google Maps bug.  If I try to open
         * all the info windows at once, only the last one succeeds.
         *
         * Otherwise, it is equivalent to:
         *   for( i = 0; i < this.markers.length; ++i )
         *     this.markers[ i ].doOpen();
         */
        i = i || 0;
        if( i < this.markers.length ) {
          var onOpen = GEvent.bind(
              this.markers[ i ],
              "infowindowopen",
              this,
              function(){
                GEvent.removeListener( onOpen );
                this.chainOpen( i + 1 );
              });
          this.markers[ i ].doOpen();
        }
        else {
          //alert('GMapEZ loadtime: ' + ( new Date() - startdate ) );
        }
      }
    };

    function EZInfoMarker( map, point, icon ) {
      GMarker.call( this, point, icon );
      this.map = map; // circular ref?
      this.html = null;
      this.infoZoomOffset = undefined;
      this.infoZoomLevel = undefined;
      this.infoMapType = null;
    }
    EZInfoMarker.prototype = new GMarker();
    EZInfoMarker.prototype.constructor = EZInfoMarker;

    EZInfoMarker.prototype.doOpen = function() {
      var zoom = null;
      if( this.html ) {
        this.openInfoWindowHtml( this.html );
      }
      else {
        if( this.infoZoomOffset != undefined )
          zoom = this.map.getZoomLevel() + this.infoZoomOffset;
        else if( this.infoZoomLevel != undefined )
          zoom = this.infoZoomLevel;

        if( zoom >= this.map.spec.numZoomLevels )
          zoom = this.map.spec.numZoomLevels - 1;
        else if( zoom < 0 )
          zoom = 0;

        this.showMapBlowup( zoom, this.infoMapType );
      }
    };

    function EZMap( div, classes ) {
      this.div = div;
      this.classes = classes;

      /*
      this.map;
      this.marker = undefined;
      this.minX = undefined;
      this.maxX = undefined;
      this.minY = undefined;
      this.maxY = undefined;
      */
      this.mapType = undefined;
      this.pointCount = 0;
      this.center = undefined;
      this.span = undefined;
      this.explicitExtent = false;

      this.init();
    }

    EZMap.prototype.logWarning = function( str ) {
      if( ! this.warningNode ) {
        this.warningVis = false;
        this.warningNode = document.createElement('ul');
        this.warningNode.className = 'warnings';
       // div.appendChild( this.warningNode );

        var warnBtn = document.createElement('button');
        warnBtn.className = '';
        warnBtn.innerHTML = '';
        div.appendChild( warnBtn );
        GEvent.bindClick( warnBtn, this, this.toggleWarnings );
      }
      var li = document.createElement('li');
      li.innerHTML = str;
      this.warningNode.appendChild( li );
    };

    EZMap.prototype.toggleWarnings = function() {
      this.warningVis = ! this.warningVis;
      this.warningNode.style.display = this.warningVis ? 'block' : 'none';
    };

    EZMap.prototype.processMarkers = function( parentNode, drawline ) {
      var pointList = [];
      for( var node = parentNode.firstChild; node; node = node.nextSibling){
        switch( node.nodeName ) {
        case 'A':
          this.marker = undefined;
          var textContent = node.innerHTML.replace( /<[^>]*>/g, '' );
          var openThisMarker = /\bOPEN\b/.exec( textContent );
          textContent = textContent.replace( /\bOPEN\b/, '' );
          textContent = textContent.replace( /^\s*/, '' );
          textContent = textContent.replace( /\s*$/, '' );
          if( textContent == 'EXTENT' )
            this.explicitExtent = true;

          var matchll = /\Wll=([-.\d]*),([-.\d]*)/.exec( node.href );
          if( matchll ) {
            ++this.pointCount;
            var x = parseFloat( matchll[2] );
            var y = parseFloat( matchll[1] );
            var point = new GPoint( x, y );
            pointList.push( point );

            if( textContent == 'EXTENT' ) {
              this.center = point;
            }
            else {
              if( this.pointCount == 1 ) {
                this.minX = x;
                this.maxX = x;
                this.minY = y;
                this.maxY = y;
              }
              else {
                if( x < this.minX ) this.minX = x;
                if( x > this.maxX ) this.maxX = x;
                if( y < this.minY ) this.minY = y;
                if( y > this.maxY ) this.maxY = y;
              }

              var sym = null;
              var color = 'ORANGE';

              var matchcolor =
                  /\b(ORANGE|PURPLE|YELLOW|GREEN|BLUE|RED|AQUA|WHITE|GRAY)\b/
                  .exec( textContent );
              if( matchcolor )
                color = matchcolor[0];

              var matchsym = /\b([0-9A-Za-z]|HASH|DOLLAR|DOT|START|END)\b/.exec(textContent);
              if( matchsym )
                sym = matchsym[ 0 ];
              if( ! sym ) {
                if( ! drawline )
                  sym = 'DOT';
                else
                  continue;
              }

              var icon = new GIcon( defaultIcon );
              icon.image =
                'http://bluweb.com/us/chouser/gmapez/iconEZ2/marker-'
                + color + '-' + sym + '.png';
              this.marker = new EZInfoMarker( this.map, point, icon );
              // We must zoom the map once before adding markers
              if( ! this.map.isLoaded() )
                this.map.centerAndZoom( point, 4 );
              this.map.addOverlay( this.marker );

              idmarkers[ node.id || node.name ] = this.marker;
              if( openThisMarker )
                markerOpener.addMarker( this.marker );
            }
          }
          else {
            this.logWarning( "No ll param for marker [" + node.innerHTML +
              ":" + (node.id || node.name) + "]" );
          }

          if( this.pointCount == 1 || textContent == 'EXTENT' ) {
            var matchspn = /\Wspn=([-.\d]*),([-.\d]*)/.exec( node.href );
            if( matchspn ) {
              this.span = {
                width:  parseFloat( matchspn[2] ),
                height: parseFloat( matchspn[1] )
              };
            }

            var matchtype = /\Wt=(.)/.exec( node.href );
            if( matchtype ) {
              switch( matchtype[1] ) {
                case 'k': this.mapType = G_SATELLITE_TYPE; break;
                case 'h': this.mapType = G_HYBRID_TYPE; break;
              }
            }
          }
          break;

        case 'DIV':
          if( ! this.marker ) {
            if( this.pointCount < 1 )
              this.logWarning( "div block given before any markers" );
            else
              this.logWarning( "Multiple div blocks given for one marker" );
            continue;
          }
          else {
            var infoClasses = wordMap( node.className );
            if( 'GMapEZ' in infoClasses ) {
              // infoWindow blowup
              var matchzoom = /ZOOMLEVEL([-+=]?)(\d+)/.exec( node.innerHTML );
              if( matchzoom ) {
                var num = parseInt( matchzoom[ 2 ] );
                if( matchzoom[ 1 ] == '-' )
                  this.marker.infoZoomOffset = num;
                else if( matchzoom[ 1 ] == '+' )
                  this.marker.infoZoomOffset = - num;
                else
                  this.marker.infoZoomLevel = num;
              }

              for( typeName in MapTypeTable ) {
                if( typeName in infoClasses ) {
                  this.marker.infoMapType = window[ typeName ];
                  break;
                }
              }
            }
            else {
              // infoWindow HTML
              var width = div.offsetWidth * 2 / 3;
              var html = node.outerHTML;
              if( ! html ) {
                html = '<div';
                var attrs = node.attributes;
                for( var j = 0; j < attrs.length; ++j )
                  html += ' ' + attrs[j].name + '="' + attrs[j].value + '"';
                html += '>' + node.innerHTML + '</div>';
              }
              this.marker.html = '<div style="max-width: ' + width + 'px">' +
                  html + '</div>';
            }
            GEvent.addListener( this.marker, 'click', this.marker.doOpen );
          }
          break;

        case 'LI':
          pointList.push( this.processMarkers( node, true )[ 0 ] );
          break;

        case 'OL':
          var params = { color: null, weight: null, opacity: null };
          for( var word in wordMap( node.className ) ) {
            var matchparam = /^(color|weight|opacity):(.*)$/.exec( word );
            if( matchparam )
              params[ matchparam[1] ] = matchparam[2];
          }
          if( params.color && ! /^#[0-9a-zA-Z]{6}$/.exec( params.color ) )
            this.logWarning( 'Polyline color should be a 6-digit' +
                ' hex color like "#123abc", not "' + params.color + '"' );
          if( params.weight != null ) {
            var w = parseInt( params.weight );
            if( w < 1 || isNaN( w ) )
              this.logWarning( 'Polyline weight should be an' +
                  ' interger above 0, not "' + params.weight + '"' );
            params.weight = w;
          }
          if( params.opacity ) {
            var o = parseFloat( params.opacity );
            if( o < 0 || o > 1 || isNaN( o ) )
              this.logWarning( 'Polyline opacity should be ' +
                  ' between 0 and 1, not "' + params.opacity + '"' );
            params.opacity = o;
          }
          this.map.addOverlay( new GPolyline(
              this.processMarkers( node, true ),
              params.color,
              params.weight,
              params.opacity ) );
          break;

        case '#text':
        case '#comment':
          // ignore text and comments
          break;

        default:
          this.logWarning( "Unknown or misplaced node " + node.nodeName );
          break;
        }
      }
      return pointList;
    }

    EZMap.prototype.init = function() {
      var divData = div.cloneNode( true );
      div.innerHTML = '';
      div.style.display = 'block';

      this.map = new GMap( div );
		
      for( var ctrl in CtrlTable ) {
        if( ctrl in this.classes ) {
          this.map.addControl( new window[ ctrl ]() );
        }
      }

      this.processMarkers( divData );

      if( ! this.center ) {
        if( this.minX == undefined ) {
			
          this.map.centerAndZoom( new GPoint(-79.568481, 38.377327), 10);
		  
		  	var point=new  GPoint(-80.3498, 38.280235); 
	  		var marker=new GMarker(point);
			this.map.addOverlay(marker);
			marker.openInfoWindowHtml('<nobr><a href=cranberry.htm>Cranberry Glades</a></nobr>');
		  
		  
		  
		  	var point=new  GPoint(-79.812241, 38.095254);
	  		var marker=new GMarker(point);
		  	this.map.addOverlay(marker);
			marker.openInfoWindowHtml( '<nobr><a href=hiddenvalley.htm>Hidden Valley</a></nobr>');
			
			

			
        }
        else {
          this.center = new GPoint(
              (this.minX + this.maxX)/2,
              (this.minY + this.maxY)/2 );
          if( ! this.explicitExtent && this.pointCount != 1 ) {
            this.span = {
              width:  this.maxX - this.minX,
              height: this.maxY - this.minY
            };
          }
        }
      }

      for( typeName in MapTypeTable ) {
        if( typeName in this.classes ) {
          this.mapType = window[ typeName ];
          this.explicitExtent = true;
          break;
        }
      }

      if( this.pointCount == 1 || this.explicitExtent ) {
        if( this.mapType )
          this.map.setMapType( this.mapType );
      }

      if( this.span ) {
        var zoomLevel = this.map.spec.getLowestZoomLevel(
            this.center, this.span, this.map.viewSize );
        this.map.centerAndZoom( this.center, zoomLevel );
      }
    }

    // Find all divs marked as GMapEZ
    var divs = document.getElementsByTagName( 'div' );
    for( var i = 0; i < divs.length; ++i ) {
      var div = divs[ i ];
      var classes = wordMap( div.className );
      if( 'GMapEZ' in classes )
        new EZMap( div, classes );
    }

    // Find all anchor tags linking to GMapEZ markers
    var anchors = document.getElementsByTagName( 'a' );
    for( var mi = 0; mi < anchors.length; ++mi ) {
      var marker = markerForUrl( anchors[ mi ].href );
      if( marker )
        GEvent.bindDom( anchors[ mi ], "click", marker, marker.doOpen );
    }

    // Examine current page location for a reference to a GMapEZ marker
    var marker = markerForUrl( document.location );
    if( marker )
      markerOpener.addMarker( marker );

    // Open all the markers we need to
    markerOpener.chainOpen();
  }

  function addOnLoad( func ) {
    if( window.onload ) {
      var oldfunc = window.onload;
      window.onload = function() { oldfunc(); func(); }
    }
    else {
      window.onload = func;
    }
  }
  window.addOnLoad = addOnLoad;

  addOnLoad( loadfunc );
})();

