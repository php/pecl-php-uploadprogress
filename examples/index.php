<?php 
/*
  +----------------------------------------------------------------------+
  | Uploadprogress extension                                             |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006-2008 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Christian Stocker (chregu@php.net)                           |
  +----------------------------------------------------------------------+
*/

  $id = md5(microtime() . rand());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="HTML Tidy for Linux/x86 (vers 1 September 2005), see www.w3.org" />
<script type="text/javascript">


var UP = function() {
    
    /* private variables */
    
    var ifr = null;
    
    var startTime = null;
    
    var infoUpdated = 0;
    
    var writeStatus = function(text,color) {
        var statDiv = document.getElementById("status");
        if (color == 1 ) {
            statDiv.style.backgroundColor = "green";
        } else if (color == 2 ) {
            statDiv.style.backgroundColor = "orange";
        } else if (color == 3 ) {
            statDiv.style.backgroundColor = "red";
        } else {
            statDiv.style.backgroundColor = "white";
        }
        statDiv.innerHTML = text;
    }
    
    
    return {
        start: function() {
           ifr = document.getElementById("ifr");
           startTime = new Date();
           infoUpdated = 0;
           this.requestInfo();
        },
        stop: function() {
            var secs = (new Date() - startTime)/1000;
            var statusText = "Upload succeeded, it took " + secs + " seconds. <br/> ";
            if (infoUpdated > 0) {
                writeStatus(statusText + "You had " + infoUpdated + " updates from the progress meter, looks like it's working fine",1);
            } else {
                statusText += "BUT there were no progress meter updates<br/> ";
                if (secs < 3) {
                  writeStatus(statusText + "Your upload was maybe too short, try with a bigger file or a slower connection",2);
                } else {
                  writeStatus(statusText + "Your upload should have taken long enough to have an progress update. Maybe it really does not work...",3);
                }
                    
                
                
            }
           startTime = null;
        },
        requestInfo: function() {
                ifr.src="info.php?ID=<?php echo $id;?>&"+new Date();
        },
        
        updateInfo: function(percent, estimatedSeconds) {
            if (startTime) {
                if (percent) {
                    infoUpdated++;
                    writeStatus("Download started since " + (new Date() - startTime)/1000 + " seconds. " + Math.floor(percent * 100) + "% done, " + estimatedSeconds + "  seconds to go"); 
                } else {
                    writeStatus("Download started since " + (new Date() - startTime)/1000 + " seconds. No progress info yet");
                }
                window.setTimeout("UP.requestInfo()",1000);
            }
        }
        
        
    }

}()


</script>
<title> php5.2  uploadprogress Meter - Simple Demo</title>

</head>

<body>
  <form onsubmit="UP.start()" target="ifr2" action="server.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="UPLOAD_IDENTIFIER" value="<?php echo $id;?>" /> 
    <label>Select File:</label> 
    <input type="file" name="file" /><br />
    <label>Upload File:</label> 
    <input type="submit" value="Upload File" />
  </form>
  <div id="status" style="border: 1px black solid"> Status</div>
  <div>The info during the upload will be displayed here:</div>
  <iframe id="ifr" src="info.php?ID=<?php echo $id;?>" width="500px" height="350px" name="ifr"></iframe>
  
  <div>
  
  The actual file upload happens here (and displays info, when it's finished):
  </div>
  <iframe name="ifr2" width="500px" height="300px" id="ifr2"></iframe>
</body>

</html>
