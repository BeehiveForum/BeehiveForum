/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: register.js,v 1.2 2009-10-23 11:33:21 decoyduck Exp $ */

var captcha_data = new xml_http_request();

function captcha_reload()
{
    captcha_data.set_handler(captcha_reload_handler);
    captcha_data.get_url('register.php?webtag=' + webtag + '&reload_captcha=true');
}

function captcha_reload_abort()
{
    captcha_data.abort();
    captcha_data.close();
    delete captcha_data;
}

function captcha_reload_handler()
{
    var response_xml = captcha_data.get_response_xml();

    var captcha_img_obj = getObjById('captcha_img');
    var private_key_obj = getObjById('private_key');
    var public_key_obj  = getObjById('public_key');

    if (typeof(captcha_img_obj) == 'object') {

        if (typeof(private_key_obj) == 'object') {

            if (typeof(public_key_obj) == 'object') {

                var new_captcha_img = response_xml.getElementsByTagName('image')[0];
                var new_key_length  = response_xml.getElementsByTagName('chars')[0];
                var new_public_key  = response_xml.getElementsByTagName('key')[0];

                if (typeof(new_captcha_img) == 'object' && typeof(new_key_length) == 'object' && typeof(new_public_key) == 'object') {

                    private_key_obj.value = '';
                    private_key_obj.maxLength = new_key_length.childNodes[0].nodeValue;
                    public_key_obj.value = new_public_key.childNodes[0].nodeValue;

                    captcha_img_obj.src = new_captcha_img.childNodes[0].nodeValue;
                }
            }
        }
    }

    return true;
}
