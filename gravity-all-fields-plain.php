<?php
/*
   Plugin Name: Gravity all_fields plain
   Plugin URI: http://wordpress.org/extend/plugins/gravity-all-fields-plain/
   Support URI: https://github.com/No3x/gravity-all-fields-plain/issues
   Version: 1.0.0
   Author: Christian Z&ouml;ller
   Author URI: http://no3x.de/
   Description: Use all_fields placeholder in gravityforms notification template but without html.
   License: GPLv3
*/

/*
 * Gravity all_fields plain
 * Copyright (c) 2015 No3x
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.If not, see<http://www.gnu.org/licenses/>.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * THIS COPYRIGHT NOTICE MAY NOT BE REMOVED FROM THIS FILE
 */

if( ! function_exists( 'gravity_all_fields_plain' ) ) {
	function gravity_all_fields_plain( $notification, $form, $entry ) {
		$matches = array();
		preg_match_all("/{all_fields_plain(:(.*?))?}/", $notification['message'] , $matches, PREG_SET_ORDER);
		foreach( $matches as $match ){
			/*
			Not supported yet:
			$options = explode(",", rgar($match,2));
			$use_value = in_array("value", $options);
			$display_empty = in_array("empty", $options);
			$use_admin_label = in_array("admin", $options);
			*/

			//all submitted fields using text
			if( strpos( $notification['message'], $match[0] ) !== false ) {
				$notification['message'] = str_replace( $match[0], '', $notification['message'] );
				foreach( $form['fields'] as $id => $field ) {
					if( ! array_key_exists( $field['id'], $entry ) ) {
						continue;
					}
					$message = $entry[$field['id']];
					$notification['message'] .= $field['label'] . ': ' . $message . PHP_EOL;
				}
			}
		}
		return $notification;
	}
	add_filter( 'gform_notification',  'gravity_all_fields_plain', 10, 3 );
}