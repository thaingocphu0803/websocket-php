<div id="profile_container">

	<?php 
		include_once __DIR__ . '/components/alert.php';

		include_once __DIR__ . '/components/confirm.php';

		require_once __DIR__ . '/components/header.php'; 
	?>

	<div id="form_group_profile">
		<div class="avt-profile">
			<label for="user_avt" id="update_avt_btn" title="Click to change your avatar">
				<img id="my_avatar" src="../asset/logo.webp" alt="my avatar">
			</label>

			<input id="user_avt" name="user_avt" class="input-file" type="file" accept="image/*" onchange="handleUploadImages(event)">

			<div class="edit-fullname-group">
				<input
					id="fullname_profile"
					name="fullname_profile"
					type="text"
					placeholder="<?=  $authInfor->fullname ?>"
					value="<?=  $authInfor->fullname ?>"
					disabled>
				<div class="fullname-btn-group">
					<!-- open edit full name -->
					<button id="update_fullname_btn" class="edit-fullname-btn" title="Click to change your name" onclick="openEditFullName(this)">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20px" heigth="20px">
							<path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
						</svg>
					</button>
					<!-- save edit full name -->
					<button  class="edit-fullname-btn hidden" id="save_fullname" onclick="handleSaveFullName(this)">Save</button>
					<!-- cancel edit full name -->
					<button class="edit-fullname-btn hidden" id="cancel_fullname" onclick="handleCancelFullName(this)">Cancel</button>
				</div>
			</div>
			<span class="error"></span>

		</div>

		<form id="form_profile">

			<div class="form_profile_input">
				<label for="current_password">Current Password</label>
				<input
					id="current_password"
					class="input-form"
					name="current_password"
					type="password"
					placeholder="Enter your current password">
			</div>

			<div class="form_profile_input">
				<label for="new_password">New Password</label>
				<input
					id="new_password"
					class="input-form"
					name="new_password"
					type="password"
					placeholder="Enter your new password"
					title="Must be at least 8 character and include one uppercase letter, one lowercase letter, one number, one special character.">
			</div>

			<div class="form_profile_input">
				<label for="confirm_new_password">Confirm New Password</label>
				<input
					id="confirm_new_password"
					class="input-form"
					name="confirm_new_password"
					type="password"
					placeholder="Enter your new password again"
					title="Must be at least 8 character and include one uppercase letter, one lowercase letter, one number, one special character.">
			</div>

			<span class="error flex-align-center" id="change_pass_error"></span>

			<div class="group-btn flex-bottom">
				<button type="button" class="edit-fullname-btn" onclick="returnToDashboard()">cancel</button>
				<button type="button" class="edit-fullname-btn" onclick="handleChangePassword()">Save</button>
			</div>

		</form>
	</div>

</div>