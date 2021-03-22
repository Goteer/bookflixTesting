

const url = document.currentScript.getAttribute('url');
const imagenTapa = document.currentScript.getAttribute('tapa');
const imagenContratapa = '';


var thePdf = null;
	var scale = 1;
	var viewWidth = 300;
	var viewHeight = 600;
	var startPage = 1;

	var zoomLevel = 100;




if (!url) {
  var error = document.createElement("h1");
  error.appendChild(document.createTextNode("Error: No hay url"));
  document.body.appendChild(error);
}

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        thePdf = pdf;
        viewer = document.getElementById('flipbook');


		thePdf.getPage(1).then( function(page) {

		viewWidth = page.getViewport(scale).width;
		viewHeight = page.getViewport(scale).height;



		//Insertar tapa del libro
		tapa = document.createElement("canvas");
      	tapa.className = 'pdf-page-canvas hard';
		tapa.id = 'tapa';
		ctx_tapa = tapa.getContext('2d');
		tapa.width = viewWidth;
		tapa.height = viewHeight;
		if (imagenTapa != '') {
			tapa_img = new Image();
			tapa_img.src = imagenTapa;
			tapa_img.onload = function(){
			ctx_tapa.drawImage(tapa_img, 0, 0,  tapa.width, tapa.height);
		}
		}
		viewer.appendChild(tapa);


		//"tapa extra" para que con visualizacion de dos paginas el libro tenga sentido
		canvas = document.createElement("canvas");
		canvas.className = 'pdf-page-canvas hard';
		viewer.appendChild(canvas);






		//Renderizado del contenido del libro
        for(page = 1; page <= pdf.numPages; page++) {
          canvas = document.createElement("canvas");
          canvas.className = 'pdf-page-canvas';
		  canvas.id ='page' + page;
          viewer.appendChild(canvas);
		  renderPage(page,canvas);
        }
		if (pdf.numPages % 2 == 1) {
			canvas = document.createElement("canvas");
			canvas.className = 'pdf-page-canvas';
			viewer.appendChild(canvas);
		}


		//"contratapa extra" para que con visualizacion de dos paginas el libro tenga sentido
		canvas = document.createElement("canvas");
			canvas.className = 'pdf-page-canvas hard';
			viewer.appendChild(canvas);


		//Insertar contratapa del libro
		contratapa = document.createElement("canvas");
      	contratapa.className = 'pdf-page-canvas hard';
		contratapa.id = 'contratapa';
		ctx_contratapa = contratapa.getContext('2d');
		contratapa.width = viewWidth;
		contratapa.height = viewHeight;
		if (imagenContratapa != '') {
			contratapa_img = new Image();
			contratapa_img.src = imagenContratapa;
			contratapa_img.onload = function(){
			ctx_contratapa.drawImage(contratapa_img, 0, 0,  contratapa.width, contratapa.height);
		}
		}
		viewer.appendChild(contratapa);

		//configuracion del libro
		//startPage = (window.innerWidth/1.5 < window.innerHeight)?startPage+1:startPage;
		$("#flipbook").turn({
			height: viewHeight,
			width: viewWidth,
			duration: 500,
			acceleration: !isChrome(),
			page:startPage
		});


		/*$("#flipbook").bind("turning", function(event, page, view) {
			render;
		});*/

		setTimeout(function() {
				thePdf.getPage(1).then( function(page){
					resizeBook(page);
				});

		}, 100);

		$("#prev-page").click(function(){
			$("#flipbook").turn("previous");
		});
		$("#goto-page").click(function(){
			var targetPage = parseInt($('#gotoPageTarget').val()) + 2;
		if (targetPage <= 0) {targetPage = 1;} else if(targetPage >= $("#flipbook").turn("pages")) {targetPage = $("#flipbook").turn("pages");} else if (!targetPage){ targetPage = 1 };
			$("#flipbook").turn("page", (targetPage));
		});
		$("#next-page").click(function(){
			$("#flipbook").turn("next");
		});

		$("#zoom-in").click(function(){
			var newHeight = (parseInt($('#flipbook').css('max-height')))*1.1;
			$('#flipbook').css({'max-height':newHeight })
			var newWidth = (parseInt($('#flipbook').css('max-width')))*1.1;
			$('#flipbook').css({'max-width': newWidth})
			resizeArbitraryBook(page,(scale*=1.1))
		});
		$("#zoom-out").click(function(){
			var newHeight = (parseInt($('#flipbook').css('max-height')))*0.9;
			$('#flipbook').css({'max-height':newHeight })
			var newWidth = (parseInt($('#flipbook').css('max-width')))*0.9;
			$('#flipbook').css({'max-width': newWidth})
			resizeArbitraryBook(page,(scale*=0.9))
		});



		$(window).resize(function() {
			thePdf.getPage(1).then( function(page){
				resizeBook(page);
			});
		});

		document.onkeydown = pasarPagina;
		//document.onclick = panPage;

		//var zoom = $("#flipbook").turn("zoom");
		});
	});





    function renderPage(pageNumber, canvas) {
        thePdf.getPage(pageNumber).then(function(page) {
          viewport = page.getViewport(scale);
          canvas.height = viewport.height;
          canvas.width = viewport.width;
          page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
    });
    }

	function checkMobile() {
		return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
	}

	function isChrome() {
		return /chrome|Chrome/i.test(navigator.userAgent);
	}

	function resizeBook(page) {
				boundary = document.body;
				scale = Math.min((boundary.clientHeight / (viewHeight)),(boundary.clientWidth / (viewWidth)) );
				if (boundary.clientWidth*0.698 < boundary.clientHeight) {
					$('#flipbook').turn('display', 'single');
					$("#flipbook").turn("size", viewWidth*scale, viewHeight*scale);
				}else{

					$('#flipbook').turn('display', 'double');
					$("#flipbook").turn("size", viewWidth*2*scale, viewHeight*scale);
				}
			}
	function resizeArbitraryBook(page,scale) {
				boundary = document.body;
				if (boundary.clientWidth*0.698 < boundary.clientHeight) {
					$('#flipbook').turn('display', 'single');
					$("#flipbook").turn("size", viewWidth*scale, viewHeight*scale);
				}else{

					$('#flipbook').turn('display', 'double');
					$("#flipbook").turn("size", viewWidth*2*scale, viewHeight*scale);
				}
			}



	function pasarPagina(e) {
			e = e || window.event;

			if (e.keyCode == '107') { // tecla +
				/*if (scaleAmount <= 2) {
					scaleAmount += 0.1;
					var translateAmount = (scaleAmount-1)*10;
					document.getElementById('zoom-viewport').style.transform = `scale(${scaleAmount}) `;
				}*/


			}
			else if (e.keyCode == '109') { // tecla -
				/*if (scaleAmount > 0.2) {
					scaleAmount -= 0.1;
					var translateAmount = (scaleAmount-1)*10;
					document.getElementById('zoom-viewport').style.transform = `scale(${scaleAmount}) `;
				}*/
			}
			else if (e.keyCode == '37') { // left arrow
				$("#flipbook").turn("previous");
			}
			else if (e.keyCode == '39') { // right arrow
				$("#flipbook").turn("next");
			}


		}

		function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};



};
