<h1>YO</h1>
<table>
<thead>
<tr>
    <td>id</td>
    <td></td>
    <td>username</td>
    <td>twitter_id</td>
    <td>is_following_you</td>
    <td>is_followed_by_you</td>
    <td>last_update</td>
    <td></td>
</tr>
</thead>

<tbody>
<?php foreach ($twitter_users as $user) { ?>
<tr>
    <td><?php echo $user->id; ?></td>
    <td><img width="48" height="48" src="https://api.twitter.com/1/users/profile_image?user_id=<?php echo $user->twitter_id; ?>&size=normal"/></td>
    <td><?php echo $user->username; ?></td>
    <td><?php echo $user->twitter_id; ?></td>
    <td><?php echo $user->is_following_you; ?></td>
    <td><?php echo $user->is_followed_by_you; ?></td>
    <td><?php echo $user->last_update; ?></td>
    <td><a href="https://twitter.com/intent/user?user_id=<?php echo $user->twitter_id; ?>">link</a></td>
</tr>
<?php } ?>
</tbody>

</table>