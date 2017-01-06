<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 *
 * @package    tool_oauth2sciebo
 * @category   test
 * @copyright
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
/**
 *
 * @package    tool_oauth2sciebo
 * @category   test
 * @copyright
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oauth2sciebo_generator extends testing_block_generator {
    /**
     * Creates Course, course members, groups and groupings to test the block.
     */
    public function test_create_preparation () {
        $generator = advanced_testcase::getDataGenerator();
        $data = array();
        $callback = 'example';
        $sciebo = new \tool_oauth2sciebo\sciebo($callback);

        return $data; // Return the user, course and group objects.
    }
}