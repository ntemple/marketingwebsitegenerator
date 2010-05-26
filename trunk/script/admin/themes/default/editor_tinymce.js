<script type="text/javascript" src="{MWG_BASEHREF}/gizmos/tiny_mce/jquery.tinymce.js"></script>
<flexy:toJavascript   mwg_basehref="MWG_BASEHREF" />
<script type="text/javascript">
        $().ready(function() {
                $('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : mwg_basehref + '/gizmos/tiny_mce/tiny_mce.js',

                        // General options
                        theme : "advanced",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,

                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
                        
                        // Theme options
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|visualaid,removeformat,cleanup,code,|,fullscreen,preview,help",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "",
                        theme_advanced_buttons4 : "",                                               
                });
        });

function toggleEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}
</script>  

