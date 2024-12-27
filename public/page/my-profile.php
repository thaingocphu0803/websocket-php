<div id="profile_container">

	<?php require_once __DIR__ . '/components/header.php'; ?>

	<div id="form_group_profile">
		<div class="avt-profile">
			<label for="user_avt" id="update_avt_btn" title="Click to change your avatar">
				<img id="my_avatar" src="../asset/logo.webp" alt="my avatar">
			</label>

			<input id="user_avt" name="user_avt" class="input-file" type="file" accept="image/*" onchange="handleUploadImages(event)">


			<div class="fullname-group">
				<span class="user-fullname">Thái Ngọc Phú</span>
				<span  id="update_fullname_btn" title="Click to change your name">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20px" heigth="20px">
						<path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
					</svg>
				</span>
			</div>

			<div class="edit-fullname-group">
				<input
					id="fullname_profile"
					class="user-fullname"
					name="fullname_profile"
					type="text"
					placeholder="Thái Ngọc Phú"
					title="Must be at least 8 character and include one uppercase letter, one lowercase letter, one number, one special character.">
				<div class="btn-group">
					<button>ok</button>
					<button>cancel</button>
				</div>
			</div>

		</div>

		<form id="form_profile">

			<div class="form_profile_input">
				<label for="current_password">Current Password</label>
				<input
					id="current_password"
					class="input-form"
					name="current_password"
					type="password"
					placeholder="Enter your current password"
					title="Must be at least 8 character and include one uppercase letter, one lowercase letter, one number, one special character.">
			</div>

			<div class="form_profile_input">
				<label for="new_password">New Password</label>
				<input
					id="new_password"
					class="input-form"
					name="new_password"
					type="password"
					placeholder="Enter your new password">
			</div>

			<div class="form_profile_input">
				<label for="new_confirm_password">Confirm New Password</label>
				<input
					id="new_confirm_password"
					class="input-form"
					name="new_confirm_password"
					type="password"
					placeholder="Enter your new password again">
			</div>

			<div class="group-btn flex-bottom">
				<button>cancel</button>
				<button>Save</button>
			</div>

		</form>
	</div>

</div>