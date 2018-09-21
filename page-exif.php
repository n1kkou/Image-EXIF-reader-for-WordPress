<?php
/**
 * Template name: EXIF data
 *
 * This is the template that displays all pages by default.
 */

get_header(); ?>

			<?php
			while ( have_posts() ) : the_post() ;

			// what should be the input source of the image?
			// create wp widget with this exif reader
			$image_source = get_template_directory_uri().'/path/to/image.jpg';
			$exif = exif_read_data($image_source, 0, true);

			$exif_FILE_image_width;
			$exif_FILE_image_height;
			$exif_FILE_size;
			$exif_FILE_type;
			
			$exif_EXIF_exposure;
			$exif_EXIF_aperture;
			$exif_EXIF_iso;
			$exif_EXIF_focal_length;

			$exif_IFD0_camera_brand;
			$exif_IFD0_camera_model;
			
			foreach ($exif as $key => $section) {
				foreach ($section as $name => $val) {
					if($key == 'FILE'){
						if($name == 'FileSize'){
							$exif_FILE_size = round($val/1000)/1000 . "MB";
						}
						
						if($name == 'MimeType'){
							$exif_FILE_type = $val;
						}
					}
					
					if($key == 'EXIF'){
						if($name == 'ExposureTime'){
								$vals = explode("/", $val);
								$exif_EXIF_exposure = intval($vals[0])/intval($vals[1]) . "s";
						}
						
						if($name == 'FNumber'){
								$vals = explode("/", $val);
								$exif_EXIF_aperture = intval($vals[0])/intval($vals[1]);
						}
						
						if($name == 'ISOSpeedRatings'){
							$exif_EXIF_iso = $val;
						}
						
						if($name == 'FocalLength'){
								$vals = explode("/", $val);
								$exif_EXIF_focal_length = intval($vals[0])/intval($vals[1]) . "mm";
						}

						if($name == 'ExifImageWidth'){
							$exif_FILE_image_width = $val . "px";
						}
						
						if($name == 'ExifImageHeight' || $name == 'ExifImageLength'){
							$exif_FILE_image_height = $val . "px";
						}
					}	

					if($key == 'IFD0'){
						if($name == 'Make'){
							$exif_IFD0_camera_brand = $val;
						}
						
						if($name == 'Model'){
							$exif_IFD0_camera_model = $val;
						}
					}
					
					if($key == 'GPS'){
						echo "$key.$name: $val<br />\n";	
					}
					
					 // echo "$key.$name: $val<br />\n";	
				}
			}
			

			echo "<h3>File details</h3>";
			if(isset($exif_FILE_image_width)){
				echo "<div><b>Image width </b>" . $exif_FILE_image_width . "</div>";
			}
			if(isset($exif_FILE_image_height)){
				echo "<div><b>Image height </b>" . $exif_FILE_image_height . "</div>";
			}
			if(isset($exif_FILE_size)){
				echo "<div><b>Size </b>" . $exif_FILE_size . "</div>";
			}
			if(isset($exif_FILE_type)){
				echo "<div><b>Type </b>" . $exif_FILE_type . "</div>";
			}

			echo "<h3>Camera settings</h3>";
			if(isset($exif_EXIF_exposure)){
				echo "<div><b>Exposure </b>" . $exif_EXIF_exposure . "</div>";
			}
			if(isset($exif_EXIF_aperture)){
				echo "<div><b>Aperture </b>" . $exif_EXIF_aperture . "</div>";
			}
			if(isset($exif_EXIF_iso)){
				echo "<div><b>ISO </b>" . $exif_EXIF_iso . "</div>";
			}
			if(isset($exif_EXIF_focal_length)){
				echo "<div><b>Focal length </b>" . $exif_EXIF_focal_length . "</div>";
			}

			echo "<h3>Camera details</h3>";
			if(isset($exif_IFD0_camera_brand)){
				echo "<div><b>Camera brand </b>" . $exif_IFD0_camera_brand . "</div>";
			}
			if(isset($exif_IFD0_camera_model)){
				echo "<div><b>Camera model </b>" . $exif_IFD0_camera_model . "</div>";
			}

			endwhile; // End of the loop. ?>
<?php get_footer();
