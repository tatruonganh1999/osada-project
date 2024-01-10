<!DOCTYPE html>
<html>
<head>
<style>
	#snowflakeContainer{position:absolute;left:0px;top:0px;}
	.snowflake{padding-left:15px;font-size:14px;line-height:24px;position:fixed;color:#FFFFFF;user-select:none;z-index:1000;-moz-user-select:none;-ms-user-select:none;-khtml-user-select:none;-webkit-user-select:none;-webkit-touch-callout:none;}
	.snowflake:hover {cursor:default}
</style>
  <script
    type="text/javascript"
    src='https://cdn.tiny.cloud/1/wc500hfj5c8mroy25nrxbdgrag1e87mrju9f0ofwet7r38gw/tinymce/6/tinymce.min.js'
    referrerpolicy="origin">
  </script>
  <!-- <script src="custom.js"></script> -->
  <script src="https://cdn.tiny.cloud/1/cowslr9ajbzedvacrcyt9vvgxhqzzxtveqihtzqtdn2u083u/tinymce/5/tinymce.min.js"></script>
  <script type="text/javascript">
//     tinymce.init({
//   selector: 'textarea',  // change this value according to your HTML
//   menubar: 'file edit view'
// });

  tinymce.init({
    selector: '.myTextarea',
    width: 600,
    height: 300,
    plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'insertDivPlugin', 'textBox', 'divColumn', 'emoticons', 'template', 'help'
    ],
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help | insertDivButton |divColumn| textBox',

    content_style: 'div { background-color: #b0e0e6; padding: 10px; list-style-type: none;} a  {text-decoration: none ; }',
    // content_style: 'a { text-decoration: none }',

    menu: {
      favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
    },
    menubar: 'favs file edit view insert format tools table help',
    // content_css: 'css/content.css'
  });

  (function () {
    tinymce.PluginManager.add('insertDivPlugin', function (editor, url) {
        editor.ui.registry.addButton('insertDivButton', {
            text: 'Insert Div',
            onAction: function () {
                insertDiv(editor);
            }
        });

        function insertDiv(editor) {
            const content = '<div style="padding:15px">Your content here.</div>';
            editor.insertContent(content);
        }

        return {
            getMetadata: function () {
                return {
                    name: 'Insert Div Plugin',
                    url: 'https://example.com/docs/insertdivplugin'
                };
            }
        };
    });

    tinymce.PluginManager.add('textBox', function (editor) {
    editor.addButton('textBox', {
        text: 'Insert Text Box',
        icon: false,
        onclick: function () {
            editor.windowManager.open({
                title: 'Insert Text Box',
                body: [
                    { type: 'textbox', name: 'textBoxContent', label: 'Text Box Content' },
                    { type: 'textbox', name: 'textBoxClass', label: 'Text Box Class', value: 'custom-text-box' }
                ],
                onsubmit: function (e) {
                    var textBoxContent = e.data.textBoxContent;
                    var textBoxClass = e.data.textBoxClass;

                    var textBoxCode = '<div class="' + textBoxClass + '">' + textBoxContent + '</div>';
                    editor.insertContent(textBoxCode);
                }
            });
        }
    });
});

  })();

  // editor.execCommand(command, userInterface, value, args);
  // tinymce.activeEditor.execCommand('.myTextarea');
  </script>
</head>

<body style="background-color:skyblue">
  <h1>Truong Anh</h1>
  <div style="background-color:aliceblue;margin: auto;width: 50%;">
  <form action="{{route('create')}}" method="POST">
  @csrf
    <textarea class="myTextarea" id="myTextarea" name="content"></textarea>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>

<div id='snowflakeContainer'>
<p class='snowflake'>❄</p>

</div>
<script style='text/javascript'>
	//<![CDATA[
	var requestAnimationFrame=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame;var transforms=["transform","msTransform","webkitTransform","mozTransform","oTransform"];var transformProperty=getSupportedPropertyName(transforms);var snowflakes=[];var browserWidth;var browserHeight;var numberOfSnowflakes=50;var resetPosition=false;function setup(){window.addEventListener("DOMContentLoaded",generateSnowflakes,false);window.addEventListener("resize",setResetFlag,false)}setup();function getSupportedPropertyName(b){for(var a=0;a<b.length;a++){if(typeof document.body.style[b[a]]!="undefined"){return b[a]}}return null}function Snowflake(b,a,d,e,c){this.element=b;this.radius=a;this.speed=d;this.xPos=e;this.yPos=c;this.counter=0;this.sign=Math.random()<0.5?1:-1;this.element.style.opacity=0.5+Math.random();this.element.style.fontSize=4+Math.random()*30+"px"}Snowflake.prototype.update=function(){this.counter+=this.speed/5000;this.xPos+=this.sign*this.speed*Math.cos(this.counter)/40;this.yPos+=Math.sin(this.counter)/40+this.speed/30;setTranslate3DTransform(this.element,Math.round(this.xPos),Math.round(this.yPos));if(this.yPos>browserHeight){this.yPos=-50}};function setTranslate3DTransform(a,c,b){var d="translate3d("+c+"px, "+b+"px, 0)";a.style[transformProperty]=d}function generateSnowflakes(){var b=document.querySelector(".snowflake");var h=b.parentNode;browserWidth=document.documentElement.clientWidth;browserHeight=document.documentElement.clientHeight;for(var d=0;d<numberOfSnowflakes;d++){var j=b.cloneNode(true);h.appendChild(j);var e=getPosition(50,browserWidth);var a=getPosition(50,browserHeight);var c=5+Math.random()*40;var g=4+Math.random()*10;var f=new Snowflake(j,g,c,e,a);snowflakes.push(f)}h.removeChild(b);moveSnowflakes()}function moveSnowflakes(){for(var b=0;b<snowflakes.length;b++){var a=snowflakes[b];a.update()}if(resetPosition){browserWidth=document.documentElement.clientWidth;browserHeight=document.documentElement.clientHeight;for(var b=0;b<snowflakes.length;b++){var a=snowflakes[b];a.xPos=getPosition(50,browserWidth);a.yPos=getPosition(50,browserHeight)}resetPosition=false}requestAnimationFrame(moveSnowflakes)}function getPosition(b,a){return Math.round(-1*b+Math.random()*(a+2*b))}function setResetFlag(a){resetPosition=true};
	//]]>
</script>
</body>
</html>