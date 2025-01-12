<?php
/*
 * Copyright (c) 2010-2018 Tim Düsterhus.
 *
 * Use of this software is governed by the Business Source License
 * included in the LICENSE file.
 *
 * Change Date: 2022-11-27
 *
 * On the date above, in accordance with the Business Source
 * License, use of this software will be governed by version 2
 * or later of the General Public License.
 */

namespace chat\system\page\handler;

use \chat\data\room\RoomCache;
use \wcf\system\request\LinkHandler;
use \wcf\system\WCF;

/**
 * Default implementations for page handlers of
 * pages that operate on a specific chat room.
 */
trait TRoomPageHandler {
	/**
	 * @inheritDoc
	 */
	public function isValid($objectID) {
		$room = RoomCache::getInstance()->getRoom($objectID);

		return $room !== null;
	}

	/**
	 * @inheritDoc
	 */
	public function lookup($searchString) {
		$sql = "(SELECT ('chat.room.room' || roomID || '.title') AS languageItem
		         FROM   chat".WCF_N."_room
		         WHERE  title LIKE ?
		        )
		        UNION
		        (SELECT languageItem
		         FROM   wcf".WCF_N."_language_item
		         WHERE      languageItemValue LIKE ?
		                AND languageItem LIKE ?
		                AND languageID = ?
		        )";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ '%'.$searchString.'%'
		                    , '%'.$searchString.'%'
		                    , 'chat.room.room%.title'
		                    , WCF::getLanguage()->languageID
		                    ]);

		$results = [ ];
		while (($row = $statement->fetchArray())) {
			$roomID = preg_replace('/chat\.room\.room(\d+)\.title/', '\1', $row['languageItem']);
			$room = RoomCache::getInstance()->getRoom($roomID);
			if (!$room) continue;

			$results[] = [ 'title'       => $room->getTitle()
			             , 'description' => $room->getTopic()
			             , 'link'        => $room->getLink()
			             , 'objectID'    => $room->roomID
			             , 'image'       => 'fa-comments-o'
			             ];
		}

		return $results;
	}
}
