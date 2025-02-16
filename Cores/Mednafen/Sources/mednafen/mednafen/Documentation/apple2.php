<?php require("docgen.inc"); ?>

<?php BeginPage('apple2', 'Apple II/II+/IIe/Enhanced IIe'); ?>

<?php BeginSection('Introduction', "Section_intro"); ?>
Mednafen's "<b>apple2</b>" emulation module supports emulation of Apple II, II+, IIe, and Enhanced IIe.  It is geared more towards running individual software releases independently of other
software releases; it can be used differently, but the abstractions chosen may make it rather awkward.
<p>
The model emulated by default is the Apple II/II+, but it can be changed by altering the <a href="#apple2.model">apple2.model</a> setting, or by using the "<b>model</b>" directive in a <a href="#Section_mai">MAI file</a>.
Note that save states and modified disk image data are not shared between different emulated models(barring unlikely hash collisions),
to avoid emulated software malfunctions that may, among other effects, corrupt emulated disk data.
<?php EndSection(); ?>

<?php BeginSection("MAI System and Disks Configuration File", "Section_mai"); ?>
<p>
Single-disk single-side software can be loaded directly.  The recommended way to use multi-disk or multi-side software is to
create a special configuration file, saved with the file extension "mai", to be loaded with Mednafen.  Alternatively, the
<a href="#apple2.multiload">automatic multiload</a> feature can be used with ZIP archives.
<p>
Mednafen does not write to the floppy disk image files specified via the MAI configuration file.  Modified disk data is automatically saved into
and loaded from files in Mednafen's nonvolatile memory/save game directory.  The ID/hash used in naming these files is calculated by hashing data generated based on the
contents of the disk image files and any firmware files referenced in the MAI configuration file, along with the values of settings that control
the hardware configuration.
<p>
In addition to loading a naked MAI file, Mednafen supports automatically loading a MAI file from within a ZIP archive.  Any referenced files(e.g. floppy disk images and override firmware) must also be in
the same ZIP archive.  In regards to Mednafen selecting the correct file to open, the ordering of the MAI file in the ZIP archive in relation to other files doesn't matter.
<p>
Sample MAI configuration file:
<blockquote>
<pre>
MEDNAFEN_SYSTEM_APPLE2
# Above signature must be the first line.
#
# File paths specified in this file are relative to the directory containing
# the MAI file.
#

#
# Specify nominal model of Apple II to emulate.
#
#  Options: ii ii+ iie iie_enh
#    ii:  Apple II with 48KiB RAM, Integer BASIC, AppleSoft BASIC ROM card, and Autostart.
#    ii+: Apple II+ with 64KiB RAM, AppleSoft BASIC, and Autostart.
#    iie: Apple IIe with 128KiB RAM and DHGR support.
#    iie_enh: Enhanced Apple IIe with 128KiB RAM and DHGR support.
#
#  Default: ii+
#
model ii+

#
# Uncomment to specify available RAM, in KiB.
#
#  Options for Apple II/II+: 4 8 12 16 20 24 28 32 36 40 44 48 64
#  Options for Apple IIe: 64 65 128 320 576 1088 3136
#
#  Specifying "64" enables emulation of a RAM-based 16K language card.
#
#  Specifying "65" enables emulation of a IIe 80-column text card.
#
#  Specifying "128" enables emulation of a IIe extended 80-column text card.
#
#  Specifying "320" or higher enables emulation of a IIe RamWorks III-type card,
#    usable in some productivity software.
#
#  Defaults:
#    ii:   48
#    ii+:  64
#    iie: 128
#    iie_enh: 128
#
#ram 64

#
# Uncomment to select Apple II/II+ firmware.
#
#  Options for Apple II/II+: integer applesoft
#  Options for Apple IIe: (setting ignored)
#
#  Ignored if "firmware.override" is specified.
#
#  Defaults:
#    ii:  integer
#    ii+: applesoft
#
#firmware applesoft

# Uncomment to specify custom system firmware.
#
#  Apple II/II+: 12KiB, located at $D000-$FFFF
#  Apple IIe: 16KB, located at $C000-$FFFF
#
#  Optional; specify to override the firmware loaded via Mednafen's firmware
#  loading system.
#
#firmware.override "apple2.rom"

#
# Uncomment to select ROM card firmware for Apple II/II+.
#
#  Options for Apple II/II+: none integer applesoft
#  Options for Apple IIe: (setting ignored)
#
#  ROM card emulation is disabled if "none" is selected(regardless of
#  the "romcard.override" setting), or if 64K of RAM is selected
#  by the "ram" setting.
#
#  Defaults:
#    ii:  applesoft
#    ii+: integer
#
#romcard integer

# Uncomment to specify custom ROM card firmware for Apple II/II+.
#
#  Optional; specify to override the firmware loaded via Mednafen's firmware
#  loading system.
#
#  Note: Ignored if "romcard" is set to "none", or if 64K of RAM is selected
#  by the "ram" setting.
#
#romcard.override "applesoft.rom"

#
# Uncomment to specify custom Apple IIe Video (Character Generator) ROM, 4KiB.
#
#  Optional; specify to override the video ROM loaded via Mednafen's
#  firmware loading system.
#
#video.override

#
# Uncomment to specify custom Apple IIe Keyboard ASCII Mapping ROM, 2KiB.
#
#  Optional; specify to override the keyboard ROM loaded via Mednafen's
#  firmware loading system.
#
#kbmap.override


#
# Select game input device(s).
#
#      none: no game I/O devices
#
#   paddles: two rotary dial paddles
#
#  joystick: 2-axis, 2-button joystick, with selected default resistance
#            setting(1 through 4).
#
#   gamepad: 2-axis(D-pad), 2-button gamepad, with selected default resistance
#            setting(1 through 4).
#
#     atari: two Atari digital joyport joysticks
#            Note: Incompatible with Apple IIe, due to conflicts with the
#            Open Apple and Closed Apple keys.  As a partial workaround, hold
#            the first emulated joystick's D-pad in the left position upon
#            power-on/startup/reset.
#
# Examples:
#  gameio none
#  gameio paddles
#  gameio joystick 2
#  gameio gamepad 2
#  gameio atari
#
# Default: joystick 2
#
gameio joystick 2

#
# Specify (maximum) resistance, in Ω, for each of the four selectable
# resistance settings for the "joystick" and "gamepad" devices.
#
#  Default: 93551 125615 149425 164980
#
gameio.resistance 93551 125615 149425 164980

#
# Enable Disk II in Slot 6(with two 5.25" disk drives attached).
#
#   Default: 1
#
disk2.enable 1
disk2.drive1.enable 1
disk2.drive2.enable 1

# Select 16-sector Disk II firmware.  Options are: 13sec 16sec
#   Effectively ignored if "disk2.firmware.override" is set.
#
#   Default: 16sec
#
disk2.firmware 16sec

# Uncomment to specify custom Disk II firmware.
#
#  Optional; specify to override the Disk II firmware loaded via Mednafen's
#  firmware loading system.
#
#disk2.firmware.override "disk2_dos33_boot.rom" "disk2_dos33_seq.rom"


#
# Define available floppy disks (or sides).  Disk identifiers(the part
# immediately after "disk2.disks." must only contain characters a-z, 0-9, and _)
#
# Fields: name filepath write_protect(optional)
#  If the write_protect field is omitted, then the default write protect setting
#  for the format is used.  For WOZ disk images, write protect is explicitly
#  specified in the INFO header.  For other formats, write protect defaults
#  to off(0).
#
disk2.disks.game1 "Disk 1 - Boot" "SomeGame - Disk 1.dsk" 1
disk2.disks.game2 "Disk 2" "SomeGame - Disk 2.dsk" 1
disk2.disks.game3 "Disk 3" "SomeGame - Disk 3.dsk" 1
disk2.disks.save "Save Disk" "SomeGame - Save Disk.dsk" 0

#
# Specify which disks are allowed to go into which drive.
#
# Prefix the disk identifier with a * to start with that disk inserted.
#
# Don't insert the same disk (identifier) into different
# drives at the same time unless you're some sort of spacetime wizard.
#
disk2.drive1.disks *game1 game2 game3
disk2.drive2.disks *save

#
# Uncomment to enable ProDOS-compatible, high-level HDD emulation in specified
# slot with specified hard disk drive image.
#
# The hard disk drive image must be a multiple of 512 bytes, and no larger
# than 33,553,920 bytes(65535 * 512).
#
# Slot must be either 1 or 7.
#
# Fields: slot filepath write_protect
#
#   Default: (undefined/disabled)
#
#hdd 7 "ProDOS.hdv" 0

</pre>
</blockquote>
<?php EndSection(); ?>

<?php BeginSection("Floppy Disk Images", "Section_floppies"); ?>
<p>
 If a virtual floppy disk image in memory has been modified(written to) during the course of emulation, the in-memory floppy disk image
 will be saved into a separate file under Mednafen's nonvolatile memory directory upon exit.  On subsequent invocations with the same floppy disk
 image(or MAI file and its associated floppy disk images), this separate floppy disk image will be transparently loaded at startup and its data used in lieu
 of the source floppy disk image when creating the virtual floppy disk image in memory.
</p>

<p>
The following 5.25" Apple II floppy disk image formats are supported:
<table border>
 <tr><th>Extension:</th><th>Size(Bytes):</th><th>Description:</th></tr>
 <tr><td>d13</td><td>116480</td><td>Apple DOS 13 sectors/track</td></tr>
 <tr><td>dsk<br>do</td><td>143360</td><td>Apple DOS-order 16 sectors/track</td></tr>
 <tr><td>po</td><td>143360</td><td>Apple ProDOS-order 16 sectors/track</td></tr>
 <tr><td>woz</td><td><i>(variable)</i></td><td><a href="https://applesaucefdc.com/woz/">https://applesaucefdc.com/woz/</a></td></tr>
</table>
</p>

<?php EndSection(); ?>

<?php BeginSection("Firmware/BIOS", "Section_firmware_bios"); ?>
<p>
Place the correct firmware image files in the <a href="mednafen.html#Section_firmware_bios">correct location</a>.
</p>

<p>
If you want to use custom or modified firmware, create and load a MAI configuration file.
</p>

<p>
If you make a linear dump of your Disk II P6 sequencer ROM(s) through the P5 socket via a program running on an Apple II, remember to process the resulting data to
swap: A7 and A5, D4 and D7, D5 and D6.
</p>
<p>
In contrast, the required Disk II P5 boot ROM format has its data arranged how it appears to the 6502(i.e. as if it's just linearly dumped with
a simple program running on an Apple II).
</p>

<table border>
 <tr><th colspan="3">Apple II/II+:</th></tr>
 <tr><th>Filename:</th><th>Purpose:</th><th>SHA-256 Hash:</tr>
 <tr><td nowrap>apple2-int-auto.rom</td><td>Apple II Integer BASIC and Autostart System ROMs, concatenated(8KiB).
<p>
Consists of 2KiB ROMs(in order, with SHA-256 hashes):
<br><i>(TODO: verify 341-0001, 341-0002, 341-0003 hashes)</i>
<hr>
<p>
341-0001<br><i><font size="-1">(3a5137fa95b0a2e4a60a975a97d04abd89425295ee352aa17a3da348764d4f27)</i></font>
<p>
341-0002<br><i><font size="-1">(0ec63e5737b33f133166a3d55ed28a367a671f03960d9d57fb8598a9de6a437b)</i></font>
<p>
341-0003<br><i><font size="-1">(2ba5e31366045e5f03255f147550112a5974e3a36ed21ce585917f7c5be12869)</i></font>
<p>
341-0020<br><i><font size="-1">(29465303e7844fa56a8c846d0565e45f5ee082f98f2ccf1b261de4a7e902201b)</i></font>
</td><td>cb52b212a62f808c2f59600b2823491ee12bd91cab8e0260fe34b5f14c47552f
<br><i>(TODO: verify)</i></td></tr>
 <tr><td nowrap>apple2-asoft-auto.rom</td><td>Apple II+ AppleSoft BASIC and Autostart System ROMs, concatenated(12KiB).
<p>
Consists of 2KiB ROMs(in order, with SHA-256 hashes):
<hr>
<p>
341-0011<br><i><font size="-1">(b45168834f01e11ae2cc35fc6bef153e5a13c180503c6533dff111558099df4d)</i></font>
<p>
341-0012<br><i><font size="-1">(468d36201974ecbe22efd9164f0ead1abab00b33f1a480da525502964641f444)</i></font>
<p>
341-0013<br><i><font size="-1">(2814de134e79213eddb6d7d7a18cba105e120a08e77c9767c46d6fc3cfcc593d)</i></font>
<p>
341-0014<br><i><font size="-1">(6848707531d7a8934a58e743483e4ebc74bf2ded0229b42533fa20cb89ed1a23)</i></font>
<p>
341-0015<br><i><font size="-1">(220fb70bac6839c98901cd542c3c1fbd7145d0bb9423ea8fcc8af0f16ec47d75)</i></font>
<p>
341-0020<br><i><font size="-1">(29465303e7844fa56a8c846d0565e45f5ee082f98f2ccf1b261de4a7e902201b)</i></font>
</td><td>fc3e9d41e9428534a883df5aa10eb55b73ea53d2fcbb3ee4f39bed1b07a82905</td></tr>


 <tr><th colspan="3">Apple IIe:</th></tr>
 <tr><td nowrap>apple2e.rom</td><td>Apple IIe BASIC and System ROMs, concatenated, 16KiB.</td><td>1fb812584c6633fa16b77b20915986ed1178d1e6fc07a647f7ee8d4e6ab9d40b</td></tr>
 <tr><td nowrap>apple2e-video.rom</td><td>Apple IIe Video ROM, 4KiB, 342-0133-A</td><td>ed5bdd4afa509134e85f1d020685af7ff50e279226eb869a17825b471cc1634c</td></tr>
 <tr><td nowrap>apple2e-kb.rom</td><td>Apple IIe Keyboard ROM, 2KiB, 342-0132-B</td><td>68198ae95923926b0307893d03ec286f00822c93a0b6dabfca565f6718dd5a56</td></tr>


 <tr><th colspan="3">Enhanced Apple IIe:</th></tr>
 <tr><td nowrap>apple2e-enh.rom</td><td>Enhanced Apple IIe BASIC and System ROMs, concatenated, 16KiB.</td><td>aab38a03ca8deabbb2f868733148c2efd6f655a59cd9c5d058ef3e0b7aa86a1a</td></tr>
 <tr><td nowrap>apple2e-enh-video.rom</td><td>Enhanced Apple IIe Video ROM, 4KiB, 342-0265-A</td><td>52c3b87900ac939f6525402cab1ccfd8f8259290fc6df54da48fb4c98ae3ed0f</td></tr>
 <tr><td nowrap>apple2e-enh-kb.rom</td><td>Enhanced Apple IIe Keyboard ROM, 2KiB, 341-0132-D</td><td>a1989da84ea4381d309e7e08783771f884e913236b9bcc71c3d649aacf76537a</td></tr>


 <tr><th colspan="3">Disk II:</th></tr>
 <tr><td nowrap>disk2-13boot.rom</td><td>Disk II Interface 13-Sector P5 Boot ROM, 341-0009</td><td>2d2599521fc5763d4e8c308c2ee7c5c4d5c93785b8fb9a4f7d0381dfd5eb60b6<br><i>(TODO: verify)</i></td></tr>
 <tr><td nowrap>disk2-13seq.rom</td><td>Disk II Interface 13-Sector P6 Sequencer ROM, 341-0010</td><td>4234aed053c622b266014c4e06ab1ce9e0e085d94a28512aa4030462be0a3cb9</td></tr>

 <tr><td nowrap>disk2-16boot.rom</td><td>Disk II Interface 16-Sector P5 Boot ROM, 341-0027</td><td>de1e3e035878bab43d0af8fe38f5839c527e9548647036598ee6fe7ec74d2a7d</td></tr>
 <tr><td nowrap>disk2-16seq.rom</td><td>Disk II Interface 16-Sector P6 Sequencer ROM, 341-0028</td><td>e5e30615040567c1e7a2d21599681f8dac820edbdcda177b816a64d74b3a12f2</td></tr>
</table>
<?php EndSection(); ?>

<?php /*
<?php BeginSection("Video", "Section_video"); ?>

The images in this section are taken while running an Apple DOS sample program.  The aspect ratio is incorrect for practical reasons, and should be ignored.

<?php BeginSection("Color Luma Filters", "Section_video_color_lumafilter"); ?>

The images in this section are for demonstrating the blurring and ringing effects of the various <a href="#apple2.video.color_lumafilter">color luma filter settings</a>.
<p>
<?php for($i = -2; $i < 5; $i++) echo('<table border><tr><th>' . $i . '</th></tr><tr><td><img src="apple2_color_lumafilter_' . $i . '.png"></td></tr></table><br>'); ?>

<?php EndSection(); ?>

<?php BeginSection("Monochrome Luma Filters", "Section_video_mono_lumafilter"); ?>

The images in this section are for demonstrating the blurring and ringing effects of the various <a href="#apple2.video.mono_lumafilter">monochrome luma filter settings</a>.
<p>
<?php for($i = -2; $i < 9; $i++) echo('<table border><tr><th>' . $i . '</th></tr><tr><td><img src="apple2_mono_lumafilter_' . $i . '.png"></td></tr></table><br>'); ?>

<?php EndSection(); ?>

<?php BeginSection("Color Matrixes", "Section_color_matrixes"); ?>

The images in this section are for demonstrating the various <a href="#apple2.video.color_matrix">color matrix settings</a>.  They are taken with the <a href="#apple2.video.color_lumafilter">apple2.video.color_lumafilter</a> setting set to "2".
<p>
<?php
 $images = array("standard" => "Standard", "mednafen" => "Mednafen", "cxa1213" => "CXA1213", "cxa2025_japan" => "CXA2025 Japan", "cxa2025_usa" => "CXA2025 USA", "cxa2060_japan" => "CXA2060 Japan", "cxa2060_usa" => "CXA2060 USA", "cxa2095_japan" => "CXA2095 Japan", "cxa2095_usa" => "CXA2095 USA");

 foreach($images as $k=>$v)
 {
  echo('<table border><tr><th>' . htmlspecialchars($v) . '</th></tr><tr><td><img src="apple2_matrix_' . htmlspecialchars($k) . '.png"></td></tr></table><br>');
 }

?>

<?php EndSection(); ?>

<?php EndSection(); ?>

*/ ?>

<?php BeginSection("Input", "Section_input"); ?>

<?php BeginSection("Joystick/Gamepad", "Section_joystick_gamepad"); ?>

<table border>
 <tr><th>Game:</th><th>Preferred Resistance Setting(1, 2, 3, or 4):</th>
 <tr><td>Boulder Dash</td><td>3</td></tr>
 <tr><td>Bouncing Kamungas</td><td>2</td></tr>
 <tr><td>Mario Bros</td><td>2</td></tr>
 <tr><td>Ms. Pac-Man</td><td>2</td></tr>
 <tr><td>Pac-Man</td><td>2</td></tr>
 <tr><td>Stargate</td><td>1</td></tr>
 <tr><td>Thexder</td><td>2</td></tr>
 <tr><td>Wavy Navy</td><td>2</td></tr>
 <tr><td>Xevious</td><td>2</td></tr>
 <tr><td>Zaxxon</td><td>1</td></tr>
</table>

<?php EndSection(); ?>

<?php BeginSection("Atari Joystick", "Section_atari_joystick"); ?>
The following software is known to be compatible with one or more Atari joysticks(connected via an adapter to an Apple II):
<ul>
 <li>Ardy</li>
 <li>Bandits <i>(press CTRL+SHIFT+P)</i></li>
 <li>Beer Run <i>(press CTRL+SHIFT+P on control method screen)</i></li>
 <li>Berzap</li>
 <li>Borg</li>
 <li>Borrowed Time</li>
 <li>Boulder Dash</li>
 <li>Boulder Dash II</li>
 <li>Bouncing Kamungas</li>
 <li>Bubble-Head</li>
 <li>Buzzard Bait</li>
 <!-- TODO, check: Computer Foosball -->
 <li>Cyclod <i>(press CTRL+SHIFT+P)</i></li>
 <li>Dino Eggs</li>
 <li>Dogfight II <i>(virtual port 1 is player 3, virtual port 2 is player 1)</i> </li>
 <li>Fly Wars</li>
 <li>Free Fall</li>
 <li>Gorgon <i>(later version?)</i></li>
 <li>Hadron <i>(press CTRL+SHIFT+P)</i></li>
 <li>Horizon V<i>(press CTRL+SHIFT+P; uses both controllers simultaneously to control different aspects)</i></li>
 <li>Jawbreaker <i>(second release/title with the same name)</i></li>
 <li>Jellyfish</li>
 <li>Laf-Pak, Mine Sweep <i>(uses controller port typically used for player 2?)</i></li>
 <li>Lemmings <i>(Sirius Software)</i></li>
 <li>Lunar Leepers <i>(uses controller port typically used for player 2?)</i></li>
 <li>Mating Zone <i>(press CTRL+I during game for config screen)</i></li>
 <li>Miner 2049er</li>
 <li>Miner 2049er II</li>
 <li>Minotaur <i>(press CTRL+SHIFT+P)</i></li>
 <li>Mouskattack</li>
 <li>Outpost</li>
 <li>Pest Patrol</li>
 <li>Pie-Man</li>
 <li>Plasmania</li>
 <li>Roundabout</li>
 <li>Seadragon</li>
 <li>Snake Byte <i>(press CTRL+SHIFT+P)</i></li>
 <li>Space Ark <i>(press CTRL+N during game for config screen)</i></li>
 <li>Spy's Demise</li>
 <li>Star Maze <i>(Sir-Tech)</i> <i>(press A on title/demo screen)</i></li>
 <li>Stellar 7</li>
 <li>Tass Times in Tonetown</li>
 <li>Twerps <i>(press CTRL+SHIFT+P)</i></li>
 <li>Vindicator <i>(Hal Labs)</i> <i>(press RETURN on level select screen one or more times; uses controller port typically used for player 2?)</i></li>
 <li>Wavy Navy</li>
 <li>Wayout</li>
</ul>

<?php EndSection(); ?>

<?php BeginSection('Apple II/II+ Keyboard', 'Section_keyboard'); ?>
 Mednafen emulates the later II/II+ two-piece keyboard that uses the AY-5-3600 encoder.
 <p>
 Note that emulated keyboard key state is not updated unless <a href="mednafen.html#Section_input_grabbing">input grabbing</a>(by default, mapped to CTRL+SHIFT+Menu) is toggled on.
 <?php BeginSection('Default Mappings', 'Section_default_keys_keyboard'); ?>
  <p>
  <table border>
   <tr><th>Key(s):</th><th nowrap>Virtual Apple II/II+ Key:</th></tr>
   <tr><td>A<br>↑<br>Keypad 8</td><td>A</td></tr>
   <tr><td>Z<br>↓<br>Keypad 2</td><td>Z</td></tr>
   <tr><td>B <i>through</i> Y</td><td>B <i>through</i> Y</td></tr>
   <tr><td>0 <i>through</i> 9</td><td>0 <i>through</i> 9</td></tr>
   <tr><td>-</td><td>:</td></tr>
   <tr><td>=</td><td>-</td></tr>
   <tr><td>Insert</td><td>RESET</td></tr>
   <tr><td>Tab<br>ESC</td><td>ESC</td></tr>
   <tr><td>[<br>ALT</td><td>REPT</td></tr>
   <tr><td>\<br>Enter<br>Home</td><td>RETURN</td></tr>
   <tr><td>Caps Lock<br>CTRL</td><td>CTRL</td></tr>
   <tr><td>;<br>Keypad 4</td><td>;</td></tr>
   <tr><td>Backspace<br>⭠<br>Keypad 5<br>Delete</td><td>⭠</td></tr>
   <tr><td>⭢<br>Keypad 6<br>Page Down</td><td>⭢</td></tr>
   <tr><td>SHIFT</td><td>SHIFT</td></tr>
   <tr><td>,</td><td>,</td></tr>
   <tr><td>.</td><td>.</td></tr>
   <tr><td>/<br>End</td><td>/</td></tr>
  </table>
  </p>
 <?php EndSection(); ?>

<?php EndSection(); ?>

<?php BeginSection('Apple IIe Keyboard', 'Section_keyboard_apple2e'); ?>
 Note that emulated keyboard key state is not updated unless <a href="mednafen.html#Section_input_grabbing">input grabbing</a>(by default, mapped to CTRL+SHIFT+Menu) is toggled on.
 <?php BeginSection('Default Mappings', 'Section_default_keys_keyboard_apple2e'); ?>
  <p>
  <table border>
   <tr><th>Key(s):</th><th nowrap>Virtual Apple IIe Key:</th></tr>
   <tr><td>Insert</td><td>RESET</td></tr>
   <tr><td>ESC</td><td>ESC</td></tr>
   <tr><td>Tab</td><td>TAB</td></tr>
   <tr><td>CTRL</td><td>CONTROL</td></tr>
   <tr><td>SHIFT</td><td>SHIFT</td></tr>
   <tr><td>Caps Lock</td><td>CAPS LOCK</td></tr>
   <tr><td>Left ALT<br>Left Windows</td><td>Open Apple ○</td></tr>
   <tr><td>Right ALT<br>Right Windows</td><td>Closed Apple ●</td></tr>
   <tr><td>Space</td><td>Space</td></tr>
   <tr><td>Enter</td><td>RETURN</td></tr>
   <tr><td>Backspace</td><td>DELETE</td></tr>
   <tr><td>⭠</td><td>⭠</td></tr>
   <tr><td>⭢</td><td>⭢</td></tr>
   <tr><td>⭣</td><td>⭣</td></tr>
   <tr><td>⭡</td><td>⭡</td></tr>
   <tr><td>A <i>through</i> Z</td><td>A <i>through</i> Z</td></tr>
   <tr><td>0 <i>through</i> 9</td><td>0 <i>through</i> 9</td></tr>
   <tr><td>`</td><td>`</td></tr>
   <tr><td>-</td><td>-</td></tr>
   <tr><td>=</td><td>=</td></tr>

   <tr><td>[</td><td>[</td></tr>
   <tr><td>]</td><td>]</td></tr>
   <tr><td>\</td><td>\</td></tr>

   <tr><td>;</td><td>;</td></tr>
   <tr><td>'</td><td>'</td></tr>

   <tr><td>,</td><td>,</td></tr>
   <tr><td>.</td><td>.</td></tr>
   <tr><td>/</td><td>/</td></tr>
  </table>
 <?php EndSection(); ?>

<?php EndSection(); ?>

<?php EndSection(); ?>

<?php PrintCustomPalettes(); ?>

<?php PrintSettings(); ?>

<?php EndPage(); ?>
