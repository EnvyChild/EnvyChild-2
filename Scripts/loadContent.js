
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

var apiKey = 'd3b64cd0b8fc4530bb2d3b2e3d8bd869';
var newsUrl = 'https://newsapi.org/v2/everything';
// https://newsapi.org/v2/everything?sources='.$sourse[0].'&apiKey=d3b64cd0b8fc4530bb2d3b2e3d8bd869&page=2'
var categories = null;
var n = 9;
function loadContent()
{
	var filters = JSON.parse(getCookie('filters'));
	document.getElementsByTagName('h1').innerHTML = filters.length;
	//
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			categories = JSON.parse(this.responseText);
		}
		if(this.readyState == 4 && this.status == 403)
		{
			alert('403 forbidden.');
		}
		if(this.readyState == 4 && this.status == 404)
		{
			alert('404 not found.');
		}
		if(categories == null) return;
		var main = document.getElementById('main');
		for(categoryIndex = 0; categoryIndex < categories.length; ++categoryIndex)
		{
			var obj = null;
			var xhttpTopic = new XMLHttpRequest();
			xhttpTopic.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					
					var obj = JSON.parse(this.responseText);
					var plus = false;
					var minus = false;
					if(filters)
						for(i = 0; i < filters.length; ++i)
							if(filters[i]['category'] == categories[categoryIndex]['tagId'])
							{
								if(filters[i]['status'] == '-')
								{
									minus = true;
									break;
								}
								if(filters[i]['status'] == '+')
								{
									plus = true;
									break;
								}
							}
					if(!minus)
					{
						//
						main.innerHTML += '<div ' + (plus ? '  class="highlited"' : 'class="section"') + ' id="' + categories[categoryIndex]['tagId'] + '">\
							<div><a href="#' + categoryIndex + '" onclick="return loadCategory(this, 1);">' + categories[categoryIndex]['title'] + '</a></div>' +
							(
								!getCookie('email') ? '' :
							'<form name="add_filter" action="" method="post">\
								<input type="hidden" name="category" value ="' + categories[categoryIndex]['tagId'] + '" />\
								<input type="submit" name="status" value="+" />\
								<input type="submit" name="status" value="-" />\
							</form>') +
							'</div>';
						//*/
						for(i = 0; i < n; ++i)
						{
							var topicNode = document.createElement('div');
							topicNode.setAttribute('class', 'topic');
							topicNode.innerHTML = '<a href=' +
				                obj.articles[i].url + '>' +
				                '<span class="title">' +
				                obj.articles[i].title.substring(0, 100) + "..." +
				                '</span><span class="publisedDate">' + obj.articles[i].publishedAt +
				                '</span></a><hr /><div><img class="img" alt="image not found" src="' +
				                obj.articles[i].urlToImage +
				                '" /></div><hr /><div class="description">' +
				                obj.articles[i].description.substring(0, 85) + "..." + '</div>';
							main.appendChild(topicNode);
						}
					}
				}
			};
			xhttpTopic.open('GET', newsUrl + '?sources=' + categories[categoryIndex]['source'] + '&sortBy=top&apiKey=' + apiKey + '&page=1', false);
			xhttpTopic.send();
		}
		var menuItemCategory = document.querySelector('#headerCase .hedderButtons ul .menu__list .menu__drop');
		for(categoryIndex = 0; categoryIndex < categories.length; ++categoryIndex)
		{
			menuItemCategory.innerHTML += '<li><a href="#' + categoryIndex + '" onclick="return loadCategory(this, 1);">' + categories[categoryIndex]['title'] + '</a></li>';
		}
	};
	xhttp.open("GET", 'news_content.json', true);
	xhttp.send();
};

function loadCategory(anchor, page)
{
	var categoryIndex = parseInt(anchor.href.substring(anchor.href.indexOf('#') + 1));
	var main = document.getElementById('main');
	main.innerHTML = '<div class="section" id="' + categories[categoryIndex]['tagId'] + '">\
		<div>' + categories[categoryIndex]['title'] + '</div>';

	var obj = null;
	var xhttpTopic = new XMLHttpRequest();
	xhttpTopic.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			obj = JSON.parse(this.responseText);
		}
	};
	xhttpTopic.open('GET', newsUrl + '?sources=' + categories[categoryIndex]['source'] + '&sortBy=top&apiKey=' + apiKey + '&page=' + page, false);
	xhttpTopic.send();

	for(i = 0; i < obj.articles.length; ++i)
	{
		var topicHTML = '<div class="topic"><a href=' +
            obj.articles[i].url + '>' +
            '<span class="title">' +
            obj.articles[i].title.substring(0, 100) + "..." +
            '</span><span class="publisedDate">' + obj.articles[i].publishedAt +
            '</span></a><hr /><div><img class="img" alt="image not found" src="' +
            obj.articles[i].urlToImage +
            '" /></div><hr /><div class="description">' +
            obj.articles[i].description.substring(0, 85) + "..." + '</div></div>';
		main.innerHTML += topicHTML;
	}
		main.innerHTML += '<div class="butt1 tick">\
						<a href="#' + categoryIndex + '" onclick="return ' + (page > 1 ? 'loadCategory(this, ' + (page - 1) + ')' : 'false') + ';" > << </a>\</div>';
	main.innerHTML += '<div class="butt2">\					<a href="#' + categoryIndex + '" onclick="return loadCategory(this, ' + (page + 1) + ');" > >> </a>\
					</div>';
	//window.location.href += anchor.href.substring(anchor.href.indexOf('#'));
	return false;
};





/* Плавне появлення кнопки вгору*/
$(function () {

    $(window).scroll(function () {

        if ($(this).scrollTop() != 0) {

            $('#toTop').fadeIn();

        } else {

            $('#toTop').fadeOut();

        }

    });

    $('#toTop').click(function () {

        $('body,html').animate({ scrollTop: 0 }, 800);

    });

});