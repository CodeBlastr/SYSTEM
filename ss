[33mcommit bf6850fcb82e77091d09e4e2c0fd3aea2b0dcc16[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Fri Dec 24 04:49:04 2010 +0530

    forums plugin.
    
    forums controller backend model changes and admin display

[33mcommit e83005c4477de361b0aa379fe23675c1805542be[m
Merge: 7888915 e3aa43a
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 18:04:41 2010 -0500

    Merge branch 'dev' into social

[33mcommit e3aa43aacc834a284b5639b72200dbacf89dbe7d[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 18:04:14 2010 -0500

    User sign up fully tested, with Gallery Images

[33mcommit 4e949a35b0f97e616239d123a018b2faa1611f6d[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 17:37:13 2010 -0500

    Temporary Commit to Revert

[33mcommit 3befb5595d62735ff316e9e1d023d42786547a00[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 17:23:56 2010 -0500

    User Core to User Plugin Conversion Seemingly Complete.
    
    There may be some missed parts so far, but at first glance it seems the change to having profiles become part of the converted users plugin is complete.

[33mcommit 719b0961b63e7dd06994a4e3916fe31826f31acd[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 14:22:24 2010 -0500

    Major Change - Users Moved to Plugin, Cupcake Forum Deleted, and new Message Plugin.
    
    By combining users and profiles into a users plugin we will make two things which are 100% related much easier to find and manage.  The cupcake forum was deleted because it does not make integration into an existing user system easy, and so its easier to just write our own forum plugin. And the Message plugin was moved from profiles to its own plugin, for more extensibility.

[33mcommit a1734c8d90f23ebff7870e903bd764f7f7ed04ea[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 10:48:22 2010 -0500

    Got rid of a notice message.

[33mcommit 7888915501057cf87d8c87a17bfb0fbdc0747cae[m
Merge: b896a90 d9fe12a
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 10:36:42 2010 -0500

    Merge branch 'dev' into social

[33mcommit d9fe12a3567440c97f39a97a96f1289670f894d4[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 10:34:19 2010 -0500

    Updated Allowed Actions Usage.
    
    Now if the action appears in the allowed actions array, we will not run any other checks on permissions.  This should fix a redirection bug, which was causing the check to fail and redirect to a failing page, and redirect, and redirect, and redirect.

[33mcommit 92fe4f6e5a80ad7fd3b69db42a17425f11e015e6[m
Merge: fad188d de4a17b
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 09:11:32 2010 -0500

    Merge branch 'ecommerce' into dev

[33mcommit de4a17ba336059942965c1cbcf6b41f61c371e66[m
Merge: 28e2a1a 2efc777
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 09:04:51 2010 -0500

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit b896a90df3d1521f7160552dfbd2f273effb6448[m
Merge: c83cc30 2efc777
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 01:04:41 2010 -0500

    Merge branch 'social' of razorit.beanstalkapp.com:/z into social

[33mcommit c83cc30a6543b2c5081b9cc7a775990fc5b3ea5f[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 22 01:01:37 2010 -0500

    Added the forums plugin back in.

[33mcommit 2efc77713a255862b647e1edac71b7380c440feb[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Tue Dec 21 18:05:51 2010 +0530

    default category display.
    
    if no category is present in DB, category admin_add still renders the whole block and let user enters it . Added null parent_id option as parent for categories

[33mcommit 3d1ecbfa06b898bbf83796a0ac61e34368f0a94a[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Tue Dec 21 17:47:55 2010 +0530

    order of price matrix.
    
    The price matrix was rendering wrong data. put order by in it:

[33mcommit fad188dc36c9f56b050512cc4cbbf1a787560521[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 22:47:01 2010 -0500

    updated fyn

[33mcommit 4316709f2b1f1d0fd82906c15fdfaf38341aaf4f[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 18:20:51 2010 -0500

    small on call page updates fyn

[33mcommit 73bbf79926b717363d24ad40af11d7528ddea583[m
Merge: 640e737 3b9a92c
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 17:05:51 2010 -0500

    Merge branch 'dev' of razorit.beanstalkapp.com:/z into dev

[33mcommit 3b9a92c6a072e21702a76bee16b9d48b1260b274[m
Author: Joel Byrnes <joel@razorit.com>
Date:   Mon Dec 20 17:05:08 2010 -0500

    fyn update

[33mcommit 640e737f0b0076b5d20ea82b591229fd8c067b1e[m
Merge: eb62492 de87c76
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 17:03:11 2010 -0500

    Merge branch 'dev' of razorit.beanstalkapp.com:/z into dev

[33mcommit de87c7696ac7620ac1c136eda92a646c0825b5ae[m
Author: Joel Byrnes <joel@razorit.com>
Date:   Mon Dec 20 17:01:55 2010 -0500

    basic fyndes CSS template

[33mcommit eb62492c31b5fb87944477f14bfc9c1e0c91240d[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 16:58:55 2010 -0500

    Updated Gallerific CSS slightly.
    
    The css for gallerific is too restrictive.  We need to update that css so that the container div sets the width and height, and the rest just flows.  Not quite done, but there is a little headway made.

[33mcommit e3031d8d9c01b9c9e0f5287e58c82d93d9e5a861[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 20 14:19:56 2010 -0500

    added new site fyn

[33mcommit 3c151cfe587dd0df73ade8f2e1e0d0f96b2f31a2[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 19 18:02:07 2010 -0500

    Added Latest DB Dump

[33mcommit 28e2a1a70d2d91c0f06be3c766d017d83d770406[m
Merge: a225623 b027e0f
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 19 14:43:38 2010 -0500

    Merge branch 'design' into ecommerce

[33mcommit 97e015bb960f4b18d2c44c2c9c6baadea1be9ea2[m
Merge: baca007 b027e0f
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 18:00:25 2010 -0500

    Merge branch 'design' into dev

[33mcommit baca007ca3a1deb3b9fd615fbd859df22ef544c9[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:57:55 2010 -0500

    weird again

[33mcommit 681a61493e850c9718602cc6651200f9ed294caf[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:57:18 2010 -0500

    weird

[33mcommit b027e0f9c861a8a37d54a05d5b6712e0958a9576[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:55:35 2010 -0500

    Ready to publish first pass at new admin design.

[33mcommit 49824746db2a21c13e5c6410658ab9c5cb342618[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:44:42 2010 -0500

    Deleted 5 or more javascript file references (files were not deleted)

[33mcommit 54901f4193cfd9f62b7ba10ae8173adbd10e0383[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:24:33 2010 -0500

    Deleted references to container in the css.

[33mcommit 39b0613b4db0c773310ee98c634831d9dc4ea5f1[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 17:22:01 2010 -0500

    New Admin Design Almost Done.
    
    I'm about to make some irreparable changes, and need a jump back point in case it really screws up.

[33mcommit 3fdd0fcea8915d23f97a3d5bcc27050b54dd8215[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 15:08:17 2010 -0500

    Another admin redesign.  The last just didn't cut it.

[33mcommit 08fefffc65604779a22aac14e912836ad0e99e38[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 15:07:58 2010 -0500

    Another admin redesign.  The last just didn't cut it.

[33mcommit 0c73a73152a95532877de5553775bb5dd889ecb0[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 10:49:09 2010 -0500

    rit updates

[33mcommit a2256238ece42523f09747f15f5f93b7f410ce5b[m
Merge: df69472 e30c52c
Author: Arpan@enbake <arpan@enbake.com>
Date:   Fri Dec 17 16:54:30 2010 +0530

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit df6947221772980cd8c016eefa005a68afe303c0[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Fri Dec 17 16:52:10 2010 +0530

    price matrix for an item
    
    Saving Advanced pric matrix in 2d for an item

[33mcommit e30c52cf2ca2dc1c9a2597bfed733d83e28956da[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 00:53:59 2010 -0500

    Admin Redesign Shell Complete.
    
    The shell redesign for the admin section has been completed.  Next up is the scaffold views, so that the content section gets updated.

[33mcommit c0efc22a2c174aee058a31301af3de0e793e6597[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 17 00:06:37 2010 -0500

    Major update to the look and feel of the admin section.
    
    This is finally an implementation of the admin redesign.  Looks way better, but isn't finished.

[33mcommit 5f6d4f2143117573da7d4b026f549550a2a57bd9[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 21:58:36 2010 -0500

    Allowing admin users to choose any user group for profile register

[33mcommit 1a448b2e0aad24f55063c66edd69d023db0fa8bf[m
Merge: 7c3e80e 731dc31
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 21:48:56 2010 -0500

    merged dev

[33mcommit 7c3e80e176e75c88edbcc93606c86558b5a96ca7[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 21:45:06 2010 -0500

    quick gtrt delete

[33mcommit 64cba11234eef8db1973ecac71fe87f72a5b52d5[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 21:40:42 2010 -0500

    Updated Profile snpsht element, and Created Gallery thumb element.
    
    The profile element now calls the gallery element if you use the settings, useGallery, and send the profileId, otherwise it uses the soon to be dprecated avatar_url html.  The gallery element calls the thumb image and links to the gallery by default. That can be over-ridden with the plugin array.  Overall this is a great update, because it makes use of an easy way to display the users profile thumb, and the gallery thumb anywhere on the site, with a simple element call to the 'thumb' element.

[33mcommit 731dc314b69807c49d366698a2ff5736f0d5cdb7[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Fri Dec 17 03:16:55 2010 +0530

    price addition in item, remove category
    
    edit catalog item. Remove category link. Multiple category addition and hidden elements maintainance.

[33mcommit 69523ffb4a38a8d6b1fce7c30fce4c470a307443[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 16:04:32 2010 -0500

    Fixed Profile Creattion from the Admin Bugs.
    
    Fixed a few bugs to make profile creation work when doing it from the admin version of the register page.  Also changed the image avatar field to a gallery upload as well.  So now your profile avatar is the beginning of your first gallery.

[33mcommit 20d49ca49008a33e9769a17357c62a0056adea0a[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 16 13:59:59 2010 -0500

    Updated Profile Registrations, with a required Constant.
    
    For public registration to work now, you have to set the __APP_DEFAULT_USER_REGISTRATION_GROUP_ID setting in the settings table.  This may be changed in the future to make  user group selectable, but for security it is now required.

[33mcommit b4d4a9f57bf532731431320edaebac262aaca2be[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 23:40:05 2010 -0500

    General Bug Fixing. (and upgraded live sites)

[33mcommit 6128827287342863afe64aeff2e743d2e7109b46[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 15:35:06 2010 -0500

    Deleted Gallery Helper References in Webpages, and Profiles

[33mcommit 45e6e6427c9c34cabbf09dc194efecfdc260dcf4[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 14:53:43 2010 -0500

    merge ecommerce

[33mcommit f2f2ec42f18490b1a85d5d919c7dee7de82e3ccd[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 01:10:29 2010 -0500

    just a few notes added

[33mcommit d02b04a6c11accb655a2a0c161996b82a5a4b21f[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 00:44:04 2010 -0500

    Minor Gallery Updates.
    
    Just did some testing of galleries, and made a few non-notable updates.

[33mcommit 93b1b1bca0da8f424fcf000bb33813cd85bc2abe[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 00:34:00 2010 -0500

    Catalog Items views now show Galleries.
    
    This update makes it so that the Gallery elements are used on catalog item pages.

[33mcommit 61bb622ec96857927bafa2526dde42c03de48d0e[m
Author: Richard Kersey <github@razorit.com>
Date:   Wed Dec 15 00:03:33 2010 -0500

    Major Galleries Plugin Upgrade.
    
    The galleries plugin is now pretty solid as far as is reusability, and ease of reusability.  It is now as simple as uploading an image, and if there is a gallery_id given it adds the image to that gallery, and if not, then it creates a new gallery.  And it only takes a call to the GalleryImage->add function to make it all happen.

[33mcommit ea4bcd0e5a37580b57e1b383944c2f3c34e8af49[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 21:25:05 2010 -0500

    Changed Gallery Display to Elements.
    
    Previously galleries were displayed using a helper.  It has been switched to using elements, where the name of the element is the type of gallery you want to display.  This is good, because if you want to add new gallery types, you would add them to the gallery type array, and add a gallery element which uses the fields.  Its a nice upgrade, but I'm sure we could take it a bit further and make the types database driven as well.

[33mcommit 5650cfe4f6e07cf31574a93a826f5d579539eb49[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 21:24:41 2010 -0500

    Removed vendors from git ignore file, so that it would be tracked.

[33mcommit a615c2dae07126b4f1a9296a753b4e4f1ef6c62b[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 21:23:36 2010 -0500

    Added PHP Thumb vendors, in order to support automatica thumbnail resizing.

[33mcommit 9aa06aee7049f3c21080d5963f1ba72ac5560bb8[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 21:21:28 2010 -0500

    Changed Gallery Display to Elements.
    
    Previously galleries were displayed using a helper.  It has been switched to using elements, where the name of the element is the type of gallery you want to display.  This is good, because if you want to add new gallery types, you would add them to the gallery type array, and add a gallery element which uses the fields.  Its a nice upgrade, but I'm sure we could take it a bit further and make the types database driven as well.

[33mcommit 271b72fdecba42b7ac5b518a111bf8dd0002a709[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 17:37:01 2010 -0500

    Working on Making Galleries More Extensible.
    
    The goal of the next few commits, including this one, is to make galleries easily reusable throughout the entire site. So that we can have galleries for user profiles, for ecommerce products, for webpages, for blogs, for any model anywhere.

[33mcommit 4e5e1b5f62866179c8cc5f08f66b85a8fbcf3f5a[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 16:14:58 2010 -0500

    Small Formatting Changes

[33mcommit 3b04b1f64889c29d502792caca7a73ad4c386e87[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 15:14:29 2010 -0500

    Fixed Bug in Catalog Item Index Element.
    
    This fixed an if - else if that was not structured properly when using default conditions.

[33mcommit c944de355f8f47ad57cc313a171be264959f2371[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 13:43:02 2010 -0500

    Removed database name from version file.

[33mcommit 380b5a3eba0e42de32dc8184b109488af48d338e[m
Merge: 23206b7 38e5f05
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 13:34:17 2010 -0500

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit 23206b7e2cbad237a96bbc6d2610b41fe13bc346[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 13:30:05 2010 -0500

    Reusable Catalog Item Model Pagination Added.
    
    This is a model centric return of what data you want for a catalog items index view.  This was necessary because we want to show catalog item indexes all over the place, and now you can call the paginated items with conditions from any other controller, and in the view easily show the products using the products element, if you have set the catalogItems variable.

[33mcommit 38e5f05373aba1d12f31bcbc1a5d5f88d4b1b41e[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Tue Dec 14 23:49:22 2010 +0530

    category adding using new table.
    
    added category_options table to store options. options are displayed  attribute group types would be radio and options as check boxes. ajax addtion on new category page.

[33mcommit 4a8e28cb98df5384562121f55909456ffa3dee1f[m
Author: Richard Kersey <github@razorit.com>
Date:   Tue Dec 14 11:38:06 2010 -0500

    Moved Catalogs Items Index to an Element.
    
    Since we will want to display catalog items in a variety of places, we've moved the element index display to an element that can be reused in other places, like categories, and brand pages.

[33mcommit 9c0326486df29d69a217bb7cf6a1089b70542990[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 23:34:34 2010 -0500

    Order Tranasactions Updated Index Versions.
    
    I made a bunch of db changes, to clear it up and make things more like other database table standards, and added two new index versions.  Assigned, and Customer Transactions.  These are for limiting who sees what transactions, based on the user viewing.

[33mcommit e2d8a6720560da9fb39bdf40aba9a67adb017eca[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 16:36:37 2010 -0500

    Catalog Item Brands Updated.
    
    Small bug fix update, not really notable.

[33mcommit c9be384f56fd4d12b4adc68f11cf81969d5a9df1[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 16:24:36 2010 -0500

    Orders Plugin Merged with Old Name Better.
    
    Took the best we could find from the old place for the orders, and copied it over to the new named plugin files.

[33mcommit 690f5113abb1df1ed31ae9297ac81dbab0f40ae1[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 16:08:03 2010 -0500

    Added Cart Method Back to Orders Controller.

[33mcommit 067e8c713bb1eee06ba47c5d3f72d6fb3aad9db5[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 16:04:40 2010 -0500

    Catalog Items Testing.
    
    Small bug fixes, nothing notable.

[33mcommit 299d6596abe236739a62f785b65794814e111739[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 15:44:20 2010 -0500

    Tested Credits Plugin.
    
    The scaffolded credits plugin has been tested and is now working.

[33mcommit 8c7d6f2eed227bb745da975f47cb34177906bb3c[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 14:39:00 2010 -0500

    Affiliates Plugin Scaffolding Tested and Updated.
    
    Did some testing to make sure the affiliates schema and files are working, and now they are.

[33mcommit de3df60302461958b3693f3a40bb683e2c23ebfd[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 13:59:39 2010 -0500

    Updated CMS Front End Editing.
    
    Fixed a saving bug, and should be a better border around the editable area.

[33mcommit a7d5299a35fd6d49660bec693ed659f648d7ac6b[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 13:26:58 2010 -0500

    Scaffolded Affiliates and Credits Plugin.
    
    These two plugins will work hand in hand but separate enough to be two different plugins.  Affiliates will be responsible for tracking user sign up referrals (mainly).  Credits will be used for giving users some kind of value to the actions taken on the site.  I do suggest that we mainly, create functions and use Workflows and Conditions for the use of these Model functions.

[33mcommit 769a9513bc131043c61deb5a82acc7a8eb7083ed[m
Merge: 2c36792 41315a7
Author: Arpan@enbake <arpan@enbake.com>
Date:   Mon Dec 13 16:17:45 2010 +0530

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit 2c3679252334dfe7142c43900c9f40c61dba37d5[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Mon Dec 13 16:15:30 2010 +0530

    Galleries plugin in Item.
    
    User can upload images while adding item now. Meio upload behavior used. Dummy gallery is made for the item. If there exists a galllery, we add the image to it unless specified.

[33mcommit 41315a7763d7897a325bd2f9d8f15c194a900210[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 01:48:00 2010 -0500

    documentation update

[33mcommit 20679ebcf96c3bcd73a59f9dff103a7f540490a4[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 13 01:20:32 2010 -0500

    Changed Name, and Placement of Orders Plugin, and Transactions Plugin.
    
    This was done to make orders more intuitive, in how they work on this system. Where an order item is created, and the status can be incart, paid, pending, shipped, etc. So order item is your cart, and your order history, and probably a few other things, just depending on how you group them.  Which you can group by transaction_id, customer_id, status, and more.

[33mcommit 03b55d2bd4868cdeda91120b6cc91a01bff60d41[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 21:30:46 2010 -0500

    Testing and Fixing Blog Use Cases.
    
    Went through and just tried using blogs.  Added some necessary updates to make it more usable.  More can be done.

[33mcommit 3b37be558f45fb5b903eb88a6192a81fc7eca699[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 20:09:15 2010 -0500

    Updated CKEditor Button Calls.
    
    There was a mistake in the image button call, and it is now fixed across all instances of the ckeditor rich text field.

[33mcommit 4756e712d022ae628d31adeec6bcce1c3ba59ee7[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 19:16:46 2010 -0500

    Added buttons to Rich Text Form Input Types.
    
    Made sure that buttons were visible if you add a rich text type of input field to a form.

[33mcommit 11aa7dc313c32904eb26eca940e3bddb11893a94[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 18:10:06 2010 -0500

    Fixed Bug in Form Input Creation.
    
    Before this updqate the type 'richtext' was not saving properly.  It is now saving correctly and adding the db field to the table.

[33mcommit 5ac11b0a1dd922dce08777d4abcfdd9bc9546838[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 16:50:52 2010 -0500

    Error Pages Now Use the Default Template.
    
    This makes error pages a bit easier to read, because they use the default database driven template.

[33mcommit 0397187dbbc612bc27a467bf1c96523d3ea29574[m
Merge: beb5dc2 728493f
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 15:18:32 2010 -0500

    Merge branch 'cms' into ecommerce

[33mcommit beb5dc276bf970f7400156b894e235a45cc5b592[m
Merge: 1872dce 626d3bb
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 15:18:16 2010 -0500

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit 728493f87484466020c594626ee496d875976057[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 15:11:12 2010 -0500

    Added Inline Edit Patch.
    
    It didn't seem to change anything, so I sent it back, and will probably add this again later.

[33mcommit 1872dce08e099b2d0ff19499c3b6c7c90886213f[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 14:07:54 2010 -0500

    Fully Supported Extension Parsing.
    
    All sites now have the ability to parse any extension that there is a view file for.  (Including a default view file, so that you don't have to have a view file in every single place that you want to use a standardized view.)  Currently support for json view, and index, and xml view are done.

[33mcommit ffdc55f2bfc242ae70c8ecf648af7f2ec806fbdc[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 12 13:22:38 2010 -0500

    Updated View Path Find Function.
    
    This change makes the view path find function a bit lighter, and a tad easier to follow by moving everything into an array, and checking each file in the array to see if it exists, and after finding the first file that exists it returns the viewPath which matches.  This makes the layering of view files and localized view files, and multi-site view files a bit clearer.

[33mcommit 626d3bbf9e8bb604b5a3934a9e31e7ccd6f301ba[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Sun Dec 12 23:10:27 2010 +0530

     changes for addition of product item
    
    1. Unlimited depth of selection of categories.
    2. Assign multiple categories to product ( A link at bottom of page to add more).
    3. There was a conflict in brand add page.

[33mcommit 728bd801ce73752285b847a86598ea59e3e9caa1[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Sun Dec 12 17:24:00 2010 +0530

    unlimited categories support.
    
    no limit on choose_category deapth to choose form

[33mcommit aca5344e68627ed84470a5677dfe69cc52a11670[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 20:37:20 2010 -0500

    updated sql

[33mcommit 7f5c12cf56613660e5fdc56466a42b49e008aeaa[m
Merge: e4bc957 533e6fc
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 20:35:17 2010 -0500

    merged dev

[33mcommit e4bc957055eb100dfc3a9e32d6d59c54bb139688[m
Merge: 2cde683 7946a64
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 20:21:28 2010 -0500

    Merge branch 'ecommerce' of razorit.beanstalkapp.com:/z into ecommerce

[33mcommit 533e6fcd8bd42ea2545b94eed5cd2804c6fe0536[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 17:58:52 2010 -0500

    Created Default Views.
    
    Like cakephp scaffolding, we can now create default view files within /app/views/scaffolds.  These work for xml, rss, json, etc types of views. This is good because it allows us to have a reusable view for each method if needed, and make better use of reusable code.

[33mcommit 5d1005422b77aef8d217e2083ee251f742c4fca5[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 15:49:37 2010 -0500

    Documentation added for the Layers of View File Types

[33mcommit c188ff8177fe828e4e6dc05b98b3ec28f45d667b[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 15:39:06 2010 -0500

    Created Default Views.
    
    Like cakephp scaffolding, we can now create default view files within /app/views/scaffolds.  These work for xml, rss, json, etc types of views. This is good because it allows us to have a reusable view for each method if needed, and make better use of reusable code.

[33mcommit 95b71cc39b1db3f9bdf616b2a38f93f2780ddfa3[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 15:18:22 2010 -0500

    Created Default Views.
    
    Like cakephp scaffolding, we can now create default view files within /app/views/scaffolds.  These work for xml, rss, json, etc types of views. This is good because it allows us to have a reusable view for each method if needed, and make better use of reusable code.

[33mcommit 156dcc63c9bea227995d991a37693ed2dc47f70c[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 15:17:35 2010 -0500

    Created Default Views.
    
    Like cakephp scaffolding, we can now create default view files within /app/views/scaffolds.  These work for xml, rss, json, etc types of views. This is good because it allows us to have a reusable view for each method if needed, and make better use of reusable code.

[33mcommit 3d8403d96bf1c1c8a6503e0aef64ed23ef7ab1e7[m
Author: Richard Kersey <github@razorit.com>
Date:   Sat Dec 11 14:44:52 2010 -0500

    Created Default Views.
    
    Like cakephp scaffolding, we can now create default view files within /app/views/scaffolds.  These work for xml, rss, json, etc types of views. This is good because it allows us to have a reusable view for each method if needed, and make better use of reusable code.

[33mcommit 3ae7be1679d76a9ada90dba0527fa8832537f4eb[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 10 13:50:01 2010 -0500

    wwbe update

[33mcommit 0a03c7a41ecd8a028f4ce3a4eb1f333ecf03d097[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 10 11:19:12 2010 -0500

    swftrx update

[33mcommit 5e46c169d4239461ad022a710e954a8d32fe27ee[m
Author: Richard Kersey <github@razorit.com>
Date:   Fri Dec 10 11:07:56 2010 -0500

    Upgrade of swftrx

[33mcommit 0fc1ca55e60ae346e9961a6dd2d9acad2c1574a2[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 18:03:11 2010 -0500

    Webpages Inline Editing Update.
    
    Pages should now be able to be saved without causing a problem.

[33mcommit 9ae40c5cf2f959a8edb9df430ad757c5f7b0f21e[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 16:32:34 2010 -0500

    Added version number to admin template
    
    This allows you to quickly see what version of Zuha is running by visiting the admin.

[33mcommit 81ac36bc7be4213a8a15458dee51f3b3cf4739a2[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 15:47:26 2010 -0500

    quick gtrt change

[33mcommit 4503aa7811bf9a684074b4b71a22db5220a29770[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 15:29:15 2010 -0500

    quick gtrt change

[33mcommit 7f9960d47aa1016eb3a607c9dc4f41b94fd0e107[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 14:48:11 2010 -0500

    Fixed a bug in the snpsht element, added backtrace function to the core, and made cache of elements user specific.
    
    This is kind of a temporary fix to the problem of creating user specific elements (like a profile avatar) and caching them for speed purposes.  Also added a little documentation, and fixed a bug which was a real pain.  When doing requestAction from elements, it can get very tricky to find out why ACL is not working.

[33mcommit 711c9174d9f1046a7544a448eecf9f33447d5254[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 09:50:40 2010 -0500

    profile snapshot element added
    
    This element shows the profile avatar, and links for view and edit profile.  It is a reusable element which callable with {element: profiles.snpsht} in template db records.

[33mcommit b14230c517e152d5175f80fb53854a2164f4c935[m
Author: Richard Kersey <github@razorit.com>
Date:   Thu Dec 9 00:54:13 2010 -0500

    Added Profile Image and Link Element, and Updated Default Layout File.
    
    The element just gives an easy way to display your profile image, and links to edit or view your profile.  However the bigger change with this, is that we fixed the naming of database driving template tags.  We changed {element} to helper, and made {element} actually work with elements instead of helpers. This is good because the naming makes more sense, and because it will make it easier to create elements for the site without needed to edit app_controller and include the helper in the helper call.

[33mcommit 7946a64d2816b1798ff8021991f95159cef5adb0[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Tue Dec 7 03:42:57 2010 +0530

    Addition of CatalogItem.
    
    Saving the item with categories and relations.

[33mcommit b72dbb2b2e435d2e34c4ecd093e8737a23efc9b1[m
Author: Arpan@enbake <arpan@enbake.com>
Date:   Tue Dec 7 02:24:47 2010 +0530

    Assign Category on new item updates.
    
    Ajax loader image displayed. Json used. code clean up in JS.

[33mcommit fe9ff165b6b36a8e06e131fb187aafd3744ac444[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 6 12:07:55 2010 -0500

    small site upgrades

[33mcommit 4d9750cb646426e71948c286462708a5a121074d[m
Author: Richard Kersey <github@razorit.com>
Date:   Mon Dec 6 11:27:20 2010 -0500

    Temporary Authorization Limit set for the webpages edit button.
    
    Needed to temporarily hard code the visibility of the edit toggle button, so that we could publish this live, and use it.  In the future we will make it so that you can access that button by acl settings.

[33mcommit 2cde6832960bd4cf6ef825c8f5f1d8098e6549dd[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 22:21:31 2010 -0500

    Minor text typo fixes

[33mcommit 1cde3f3841f856cf727b74c539cca14b44107b52[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 22:19:50 2010 -0500

    Minor text typo fixes

[33mcommit 40796961c5f46726c98b713958e8a0a906d719a1[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 21:22:05 2010 -0500

    Updated README file with News.

[33mcommit 4086be53736f0d5668d4a12723b2044a96d8d83b[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 21:17:16 2010 -0500

    Updated README file with News.

[33mcommit 024a54c122e4568cef3cf744d233f68d9f30c450[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 21:00:53 2010 -0500

    userFields added to permissions plugin - BAD NOTE INCLUDED.
    
    This partial update pointed out that ACL is still a long ways from 100% finished. We have the record level stuff working, but it needs two LARGE updates. 1. We need to update the settings table records so that they include the action. Which will setup allowing ACL using those _create, _read, _update, _delete fields. And #2, we need to support HABTM tables for records which can have many users access them. Profiles, Tickets (think ticket_department_assignees), basically any model that belongsTo Many.

[33mcommit ceca4e6d86272105557b56f2a1f29e237fa69b43[m
Author: Richard Kersey <github@razorit.com>
Date:   Sun Dec 5 21:00:26 2010 -0500

    userFields added to permissions plugin - BAD NOTE INCLUDED.
    
    This partial update pointed out that ACL is still a long ways from 100% finished. We have the record level stuff working, but it needs two LARGE updates. 1. We need to update the settings table records so that they include the action. Which will setup allowing ACL using those _create, _read, _update, _delete fields. And #2, we need to support HABTM tables for records which can have many users access them. Profiles, Tickets (think ticket_department_assignees), basically any model that belongsTo Many.
