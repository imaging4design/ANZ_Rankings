<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    function form_ckeditor($data)
    {
        $data['language'] = isset($data['language']) ? $data['language'] : 'en';
       
        $size	= isset($data['width']) ? 'width: "'.$data['width'].'", ' : '';
        $size  .= isset($data['height']) ? 'height: "'.$data['height'].'", ' : '';
       
        $options = '{'.
                $size.
                'language: "'.$data['language'].'",
               
                stylesCombo_stylesSet: "my_styles",
               
                startupOutlineBlocks: false,
                entities: true,
                entities_latin: false,
                entities_greek: false,
                forcePasteAsPlainText: false,

		filebrowserBrowseUrl: "http://www.anzrankings.org.nz/js/ckeditor/filemanager/browser/default/browser.html?Connector=http://www.anzrankings.org.nz/js/ckeditor/filemanager/connectors/php/connector.php",
		filebrowserImageBrowseUrl : "http://www.anzrankings.org.nz/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=http://www.anzrankings.org.nz/js/ckeditor/filemanager/connectors/php/connector.php",
		
		filebrowserUploadUrl: "http://www.anzrankings.org.nz/js/ckeditor/filemanager/connectors/php/upload.php?Type=File",
		filebrowserImageUploadUrl : "http://www.anzrankings.org.nz/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image",
		filebrowserImageWindowWidth : "60%",
                filebrowserImageWindowHeight : "50%",
								
								
                toolbar :[

		[ "Source","-","Save","NewPage","DocProps","Preview","Print","-","Templates" ],
		[ "Cut","Copy","Paste","PasteText","PasteFromWord","-","Undo","Redo" ],
		[ "Find","Replace","-","SelectAll","-","SpellChecker", "Scayt" ],
		[ "Form", "Checkbox", "Radio", "TextField", "Textarea", "Select", "Button", "ImageButton", "HiddenField" ],
		
		[ "Bold","Italic","Underline","Strike","Subscript","Superscript","-","RemoveFormat" ],
		[ "NumberedList","BulletedList","-","Outdent","Indent","-","Blockquote","CreateDiv","- ","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock","-","BidiLtr","BidiRtl" ],
		[ "Link","Unlink","Anchor" ],
		[ "Image","Flash","Table","HorizontalRule","Smiley","SpecialChar","PageBreak","Iframe" ],
		[ "Styles","Font","FontSize" ],
		[ "TextColor","BGColor" ],
		[ "Maximize", "ShowBlocks","-","About" ],
                    
                ]
            }';
       
       
        $my_styles = 'CKEDITOR.addStylesSet("my_styles",
            [
                // Block Styles
                { name : "Normal Paragraph", element : "p"},
								{ name : "H1", element : "h1"},
                { name : "H2", element : "h2"},
                { name : "H3", element : "h3"},
                { name : "Heading 4", element : "h4"},
                { name : "Heading 5", element : "h5"},
                { name : "Heading 6", element : "h6"},
                { name : "Document Block", element : "div"},
                { name : "Preformatted Text", element : "pre"},
                { name : "Address", element : "address"},
           
                // Inline Styles
                { name: "Centered paragraph", element: "p", attributes: { "class": "center" } },
               
                { name: "IMG bordered", element: "img", attributes: { "class": "bordered" } },
               
                { name: "IMG left", element: "img", attributes: { "class": "left" } },
                { name: "IMG right", element: "img", attributes: { "class": "right" } },
               
                { name: "IMG left bordered", element: "img", attributes: { "class": "left bordered" } },
                { name: "IMGright bordered", element: "img", attributes: { "class": "right bordered" } },
            ]);';
       
        return
        // fix: move to <HEAD...
				'<script type="text/javascript" src="'.base_url().'js/ckeditor/ckeditor.js"></script>
				 <script type="text/javascript" src="'.base_url().'js/ckeditor/adapters/jquery.js"></script>'.
				

        // put the CKEditor
         '<script type="text/javascript">' .
          $my_styles .
          'CKEDITOR.replace("'.$data['id'].'", ' . $options . ');</script>';
    }
		
		
?>