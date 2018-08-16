<?php
class PageData
{
    private $adminScript;
    private $logInOut;
    private $admin;
    private $path;
    
    public function __construct($bool=true){
		$server = $_SERVER['HTTP_HOST'];
		//you will need to add your path here....
        $this->path ="http://russet.wccnet.edu/~cfleming/web230/cms/code/";
	}

    //these getter functions return the private property values to the
    //calling object.
    public function getAdminScript(){
        return $this->adminScript;   
    }
    
    public function getLogout(){
        return $this->logout;   
    }
    
    public function getLogInOut(){
        return $this->logInOut;   
    }
    
    public function getAdmin(){
        return $this->admin;   
    }
    
    //This loads the scripts needed based upon whether we are in admin or non-admin mode.
    public function pageSetup(){
        session_start();
        /*By default I call the mainobj.init of the main script
        this only contains methods for the pages when they are
        in non admin mode
        */
        $this->adminScript = '<script type="text/javascript" src="js/main.js"></script>';
        $this->adminScript .= '<script>mainObj.init()</script>';
        $this->logout="";

        //If in admin mode the extra scripts load and the page is editable
        if (isset($_SESSION['admin'])){
            if ($_SESSION['admin']==='authorized'){
                $this->adminScript = '<script src="tinymce/tinymce.min.js"></script>';
                $this->adminScript .='<script src="js/tinymce.js"></script>';
                $this->adminScript .= '<script src="js/Ajax.js"></script>';
                $this->adminScript .='<script src="js/admin.js"></script>';
                $this->logInOut='<br /><span><a href="logout.php">logout</a></span>';
                /*set the $admin flag to true so the application knows it is
                in admin mode*/
                $this->admin=true;
            }
        }
         //since a sesssion was created using the session start but not needed because
        //we are in non-admin mode then remove session and cookie.
        else{
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            $this->logInOut='';
          }
    }
    
    //loads XML file.  $path is the path to the XML file that is passed in the parameter
    public function getXML($path){
		$xml = simplexml_load_file($path);
		return $xml;
	}

	/*gets the xml file that contains the navigation information and displays
	navigation links*/ 
	public function generateNav(){
		$n = "<ul>";//$n is short for navigation
		if (file_exists('content-files/nav.xml')) {
			//$xml = simplexml_load_file('content-files/nav.xml');
			$xml = $this->getXML('content-files/nav.xml');
			foreach($xml->children() as $nav){
				$n .= "<li><a href='$nav->file'>$nav->name</a></li>";
			}
			$n .= "</ul>";
			return $n;
		} 
		else {
		    exit('Failed to open nav.xml.');
		}
	}
	
	//generates the services.
	public function generateServices(){
		$s = "<ul>";//$s is short for services
		if (file_exists('content-files/services.xml')) {
			$xml = simplexml_load_file('content-files/services.xml');
			foreach($xml->children() as $ser){
				$s .= "<li class='hide'><input type='text' value='$ser' /></li>";
				$s .= "<li class='display'>$ser</li>";
			}
			$s .= "</ul>";
			return $s;
		} 
		else {
		    exit('Failed to open services.xml.');
		}
	}
	
	//I may have to use an array here so I can sort by date
	public function getSermons($admin,$filePath){
		/*I had to do this because the paths may be different depending on what
		file is using the class.  The default is the file in relationship to the index
		page because that is mostly used.*/
				
		$s='';//$s is short for sermons
		if ($admin){
			$s .= '<form id="uploadSermon" class="uploadFiles" enctype="multipart/form-data" method="post"><fieldset><legend>Upload Sermon</legend>';
			$s .= '<div>';
			$s .= '<label>File Name:<br /><input type="text" id="fileName" /></label>';
			$s .= '<label>File:<br /><input type="file" id="file" name="file" accept="application/pdf" /></label>';
			$s .= '<input type="submit" value="Submit" id="subBtn" />';
			$s .= '</div>';
			$s .= '</fieldset></form>';
		}
		
        //create the sermon table.
		$s .= "<table id='sermons' class='data'>";
		$s .="<caption>Sermons</caption>";
		$s .= "<thead><tr><th>Sermon Title</th><th style='width: 150px'>Date</th>";
		
		//if this is the admin area add the delete field
		if ($admin){$s.="<th style='width: 100px'>Delete</th>";}
		
		$s .= "</tr></thead>";
		$s .= "<tbody>";
		
		//load xml file, loop through XML file and create table listing all sermons, date of sermon, and optional.
        //delete link if in admin mode.
		if (file_exists($filePath)) {
			$xml = $this->getXML($filePath);
			$serArray = array();
			foreach($xml->children() as $ser){
				$serArray[] = $ser;
			}
			
			//this maybe a problem because of the string compare
			//this is set to decending order most recent first
			
			function cmp($a, $b){
				return strcmp($b['id'], $a['id']);
			}
			
			usort($serArray,"cmp");
						
			//foreach($xml->children() as $ser){
			foreach($serArray as $ser){
			
				//if this is the admin area add the delete column
				if ($admin){
					$s .= "<tr><td><a href='$ser->serpath'>$ser->sertitle</a></td><td>$ser->serdate</td><td class='delSermon' id='$ser[id]'>Delete</td></tr>";
				}
				else{
					$s .= "<tr><td><a href='$ser->serpath'>$ser->sertitle</a></td><td>$ser->serdate</td></tr>";

				}
			}
			
			$s .= "</tbody></table>";
			return $s;
			//echo '<pre>';
			//echo print_r($serArray);
			//echo '</pre>';
		} 
		else {
		    exit('Failed to open sermons.xml.');
		}
	}
	
	
	//I may have to use an array here so I can sort by date
	public function getNewsForms($admin,$filePath){
		/*I had to do this because the paths may be different depending on what
		file is using the class.  The default is the file in relationship to the index
		page because that is mostly used.*/
		
		$nf='';//$nf is short for newsforms
		        
        if ($admin){
			$nf .= '<form id="uploadNewsForms" class="uploadFiles" enctype="multipart/form-data" method="post" ><fieldset><legend>Upload Newsletter or Registration Form</legend>';
			$nf .= '<div>';
			$nf .= '<label>File Name:<br /><input type="text" id="eventName" /></label>';
			$nf .= '<label>Description:<br /><textarea id="eventDesc" name="eventDesc"> </textarea></label>';
			$nf .= '<label>File:<br /><input type="file" id="file" name="file" accept="application/pdf" /></label>';
			$nf .= '<input type="submit" value="Submit" id="subBtn" />';
			$nf .= '</div>';
			$nf .= '</fieldset></form>';
		}
		//this will be a trick, need this to submit through Ajax
		//this needs to asynchronously update the table
		//we dont want this to ship to the server and reload the page
		
		
        //if we are in the admin area move the table down so it is away from the upload form area
		if ($admin){
			$nf .= "<table id='newsForms' class='data' style='margin-top: 50px;'>";
		}
		else{
			$nf .= "<table id='newsForms' class='data'>";
		}
		
		$nf .="<caption>Newsletter &amp; Registration Forms</caption>";
		$nf .= "<thead><tr><th>Title</th><th>Description</th>";
		
		//if this is the admin area add the delete field
		if ($admin){$nf.="<th style='width: 100px'>Delete</th>";}
		
		$nf .= "</tr></thead>";
		$nf .= "<tbody>";
		
		//load xml file
		if (file_exists($filePath)) {
			$xml = $this->getXML($filePath);
			$nfArray = array();
			foreach($xml->children() as $v){
				$nfArray[] = $v;
			}
			
			/*this maybe a problem because of the string compare
			this is set to decending order most recent first*/
			
			function cmp($a, $b){
				return strcmp($b['id'], $a['id']);
			}
			
			usort($nfArray,"cmp");
									
			//foreach($xml->children() as $ser){
			foreach($nfArray as $v){
			
				//if this is the admin area add the delete column
				if ($admin){
					$nf .= "<tr><td><a href='$v->nfpath'>$v->nftitle</a></td><td>$v->nfdesc</td><td class='delNewsForms' id='$v[id]'>Delete</td></tr>";
				}
				else{
					$nf .= "<tr><td><a href='$v->nfpath'>$v->nftitle</a></td><td>$v->nfdesc</td></tr>";

				}
			}
			
			$nf .= "</tbody></table>";
			return $nf;
        } 
		else {
		    exit('Failed to open newsforms.xml.');
		}
	}

	/*$admin is a boolean passed to indicate whether we are in admin mode or not.
	if in admin mode the save button will appear.*/
	public function getTextContent($file, $admin){
		$f = file_get_contents('content-files/'.$file.'.txt');
		$editor = "<div id='editableArea'>$f</div>";
		if($admin){
				$editor .=  "<input type='button' class='submitbtn' value='Save' id='submitContent' />";
				//this button is only for the tinymce window, not the sermon times in the header
		}

		return $editor;
	}
	
    //used for the php contents may not be needed as that was removed
	public function getPHPContent($file, $admin){
		include_once('content-files/'.$file.'.php');
	}
    
    
}
