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

define([ 'WoltLabSuite/Core/Dom/Traverse'
       , 'WoltLabSuite/Core/Language'
       , '../MessageType'
       ], function (DomTraverse, Language, MessageType) {
	"use strict";

	class Where extends MessageType {
		render(message) {
			const fragment = super.render(message)

			const icon = elCreate('span')
			icon.classList.add('icon', 'icon16', 'fa-times', 'jsTooltip', 'hideIcon')
			icon.setAttribute('title', Language.get('wcf.global.button.hide'))
			icon.addEventListener('click', () => elHide(DomTraverse.parentBySel(icon, '.chatMessageBoundary')))

			const elem = fragment.querySelector('.jsRoomInfo > .containerHeadline')
			elem.insertBefore(icon, elem.firstChild)

			return fragment
		}
	}

	return Where
});
