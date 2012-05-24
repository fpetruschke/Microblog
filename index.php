<?php

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                                                                   *
     *   The PHP Microblog                                               *
     *                                                                   *
     *   by Mark P. Lindhout, May 2012                                   *
     *                                                                   *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // Include the markdown library
    include_once "lib/php/markdown.php";

    // include the lessphp library
    include_once "lib/php/lessc.inc.php";
    
    // include the teimago function
    include_once "lib/php/timeago.inc.php";
    

    $blog = array (
        'title'         => 'The Tiny Texts of Mark',
        'description'   => 'The thoughts and rants of a bass-player who codes the Net&hellip;',
        'keywords'      => 'mark lindhout, mark p lindhout, rotterdam, html, web design, front end development, bass guitar, bass',
        'lang'          => 'en',
        'author' => array(
            'name'      => 'Mark P. Lindhout',
            'firstname' => 'Mark',
            'twitter'   => 'marklindhout',
            'email'     => 'mark@webambacht.nl',            
        ),
    );

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $blog['lang']; ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php echo $blog['lang']; ?>">        <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php echo $blog['lang']; ?>">               <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $blog['lang']; ?>">                  <!--<![endif]-->

    <head>
        <meta charset="utf-8">

        <title><?php echo $blog['title']; ?></title>

        <meta name="description" content="<?php echo $blog['description']; ?>">
        <meta name="keywords" content="<?php echo $blog['keywords']; ?>">
        <meta name="author" content="<?php echo $blog['author']; ?>">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="lib/fonts/Gentium/font.css">

        <?php
        	try {
        		lessc::ccompile( 'lib/less/style.less', 'lib/less/style.css' );
                echo '<link rel="stylesheet" href="lib/less/style.css">';
        	}
        	catch (exception $ex) {
        		exit( $ex -> getMessage() );
        	}
        ?>

        <!--[if lt IE 9]>
        	<script src="lib/js/libs/html5.js"></script>
        <![endif]-->
    
    </head>

    <body>
    
        <div id="header-container" class="container_12">
            <header class="wrapper clearfix prefix_2 grid_10">
                <h1 id="logo"><a href="./"><?php echo $blog['title']; ?></a></h1>
            </header>
        </div>
        
        <div id="main-container" class="container_12">
            <div id="main" class="wrapper clearfix">
<?php   
        // load all *.md files from the current folder
        $files = glob("articles/*.md");
        
        // reverse sort them by filename (since that filename is the publishing date)
        arsort($files);

        if ( !isset($_GET['article']) ) {

            // Loop through    
        	foreach ( $files as $filename ) {
        	    
                // Load file into $handle variable.
                $handle = fopen($filename, "r");
                
                // load the file's last modification date into variable.
                $creationdate = filectime($filename);
                
                $title = fgets($handle);
                
                $permalink = '?article=' . $filename . '';

?>
                <article class="archive">
                    <header>
                        <time datetime="<?php echo date( 'c', $creationdate ); ?>" pubdate="pubdate" class="grid_2">
                            <span class="timeago"><?php echo time_ago( $creationdate ); ?></span>
                        </time>
                        <h3 class="title grid_10"><a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>"><?php echo $title; ?> <span class="arrow">&raquo;</span></a></h3>
                    </header>
                </article>
<?php
            fclose( $handle );
    	}
	}

	elseif ( isset($_GET['article']) ) {

	    $found = false;
    	
    	foreach ( $files as $filename ) {
    	    
        	if ( $filename == $_GET['article'] ) {

                // We found an article
        	    $found = true;
                
                // Load file into $handle variable.
                $handle = fopen($filename, "r");
                
                // load the file's last modification date into variable.
                $creationdate = filectime($filename);
?>
                <article class="single">
                    <header>
                        <time datetime="<?php echo date( 'c', $creationdate ); ?>" pubdate="pubdate" class="grid_2">
                            <span class="timeago"><?php echo time_ago( $creationdate ); ?></span>
                        </time>
                        <h2 class="title grid_10"><?php echo fgets($handle); ?></h2>
                    </header>
                    <div class="content grid_10 prefix_2">
                        <?php
                            // return content html from markdown
                            echo Markdown( fread( $handle, filesize($filename) ) );
                        ?>
                    </div>
                </article>
<?php
                fclose( $handle );
        	}
            
    	}
    	
        if (!$found) {
            echo 'The article you requested could not be found';
        }

	}
?>
            </div>
        </div>
        
        <script src="lib/js/libs/jquery-1.7.2.min.js"></script>
        <script src="lib/js/plugins.js"></script>
        <script src="lib/js/script.js"></script>
        
        <script>
        	var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']]; ( function(d, t) {
        			var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
        			g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
        			s.parentNode.insertBefore(g, s)
        		}(document, 'script'));
        </script>
    
    </body>
</html>
