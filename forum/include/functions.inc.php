<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
USA

======================================================================

======================================================================

This file is a simple list of functions that are not supported by
older PHP versions. To add an unsupported function to this list
you need to nest it within an if statement to check the PHP version
you require.

i.e:

if (version_compare(phpversion(), "4.1.0", "<")) {

   function myfunction($param1, $param2) {

     return $param1 + $param2;

   }

}

====================================================================== */

if (version_compare(phpversion(), "4.0.5", "<")) {

  function array_search($needle, $haystack)
  {
      $match = false;
    
      foreach ($haystack as $key => $value) {
          if ($value == $needle) {
              $match = $key;
          }
      }

      return $match;
  }
  
}

?>