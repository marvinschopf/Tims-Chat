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

define([ '../MessageType' ], function (MessageType) {
	"use strict";

	class Color extends MessageType {
		render(message) {
			if (message.isOwnMessage()) {
				return super.render(message)
			}
			else {
				return false
			}
		}

		shouldUpdateUserList(message) {
			return true
		}

		preProcess(message) {
			this.profileStore.expire(message.userID)
		}
	}

	return Color
});
