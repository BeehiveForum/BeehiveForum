/*======================================================================
Copyright Project Beehive Forum 2002

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
======================================================================*/

/* $Id: xml_http.js,v 1.13 2009-07-26 14:32:59 decoyduck Exp $ */

function xml_http_request()
{
    xml_http_request.prototype._handler = undefined;
    xml_http_request.prototype._request = undefined;

    xml_http_request.prototype.set_handler = function(handler_function)
    {
        this._handler = handler_function;
    }

    xml_http_request.prototype.get_url = function(url)
    {       
        var _this = this;

        this._request = this._xml_http_request();

        try {

            this._request.onreadystatechange = function() { _this._on_state_change() };
            this._request.open("GET", url, true);
            this._request.send(null);
            
        }catch(e) {

            return false;
        }
        
        return true;        
    }

    xml_http_request.prototype.get_response_xml = function()
    {
        try {
            
            return this._request.responseXML;

        }catch (e) {

            return false;
        }
    }
    
    xml_http_request.prototype.get_response_text = function()
    {
        try {
            
            return this._request.responseText;

        }catch (e) {

            return false;
        }
    }    

    xml_http_request.prototype.close = function()
    {
        delete this._request;
    }

    xml_http_request.prototype.abort = function()
    {
        try {

            this._request.onreadystatechange = function() { };
            this._request.abort();

        }catch(e) {

            return false;
        }
        
        return true;
    }

    xml_http_request.prototype._on_state_change = function()
    {
        try {
        
            if (this._request.readyState == 4) {

                if (this._request.status == '200') {

                    this._handler();
                }
            }
        
        }catch(e) {

            return false;
        }
        
        return true;
    }

    xml_http_request.prototype._xml_http_request = function()
    {
        if (window.XMLHttpRequest) {
            
            try {
                return new XMLHttpRequest();
            }catch(e) {
                return false;
            }
        
        }else {
            
            try {
                return new ActiveXObject("Msxml2.XMLHTTP");
            }catch (e) {
                try {
                    return new ActiveXObject("Microsoft.XMLHTTP");
                }catch (e) {
                    return false;
                }
            }
        }

        return false;
    }
}