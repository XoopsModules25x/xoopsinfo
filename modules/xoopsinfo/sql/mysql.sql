#
# Structure de la table mimetypes
#

CREATE TABLE mimetypes (
  mime_id mediumint(8) NOT NULL auto_increment,
  mime_ext varchar(10) NOT NULL,
  mime_types text NOT NULL,
  mime_name varchar(255) NOT NULL default '',
  mime_status tinyint(1) NOT NULL default '0',
  KEY mime_id (mime_id)
) TYPE=InnoDB;

#
# Contenu de la table 'mimetypes'
#

INSERT INTO mimetypes VALUES (1, 'aif', 'audio/aiff|audio/x-aiff|sound/aiff|audio/rmf|audio/x-rmf|audio/x-pn-aiff|audio/x-gsm|audio/x-midi|audio/vnd.qcelp', 'Audio Interchange File', 1);
INSERT INTO mimetypes VALUES (2, 'aifc', 'audio/aiff|audio/x-aiff|audio/x-aifc|sound/aiff|audio/rmf|audio/x-rmf|audio/x-pn-aiff|audio/x-gsm|audio/x-midi|audio/mid|audio/vnd.qcelp', 'Audio Interchange File', 1);
INSERT INTO mimetypes VALUES (3, 'aiff', 'audio/aiff|audio/x-aiff|sound/aiff|audio/rmf|audio/x-rmf|audio/x-pn-aiff|audio/x-gsm|audio/mid|audio/x-midi|audio/vnd.qcelp', 'Audio Interchange File', 1);
INSERT INTO mimetypes VALUES (4, 'asf', 'audio/asf|application/asx|video/x-ms-asf-plugin|application/x-mplayer2|video/x-ms-asf|application/vnd.ms-asf|video/x-ms-asf-plugin|video/x-ms-wm|video/x-ms-wmx', 'Advanced Streaming Format', 1);
INSERT INTO mimetypes VALUES (5, 'asx', 'video/asx|application/asx|video/x-ms-asf-plugin|application/x-mplayer2|video/x-ms-asf|application/vnd.ms-asf|video/x-ms-asf-plugin|video/x-ms-wm|video/x-ms-wmx|video/x-la-asf', 'Advanced Stream Redirector File', 1);
INSERT INTO mimetypes VALUES (6, 'au', 'audio/basic|audio/x-basic|audio/au|audio/x-au|audio/x-pn-au|audio/rmf|audio/x-rmf|audio/x-ulaw|audio/vnd.qcelp|audio/x-gsm|audio/snd', 'ULaw/AU Audio File', 1);
INSERT INTO mimetypes VALUES (7, 'avi', 'video/avi|video/msvideo|video/x-msvideo|image/avi|video/xmpg2|application/x-troff-msvideo|audio/aiff|audio/avi', 'Audio Video Interleave File', 1);
INSERT INTO mimetypes VALUES (8, 'bmp', 'image/bmp|image/x-bmp|image/x-bitmap|image/x-xbitmap|image/x-win-bitmap|image/x-windows-bmp|image/ms-bmp|image/x-ms-bmp|application/bmp|application/x-bmp|application/x-win-bitmap|application/preview', 'Windows OS/2 Bitmap Graphics', 1);
INSERT INTO mimetypes VALUES (9, 'css', 'application/css-stylesheet|text/css', 'Hypertext Cascading Style Sheet', 1);
INSERT INTO mimetypes VALUES (10, 'dcr', 'application/x-director', 'Shockwave Movie', 1);
INSERT INTO mimetypes VALUES (11, 'dir', 'application/x-director', 'Macromedia Director Movie', 1);
INSERT INTO mimetypes VALUES (12, 'doc', 'application/msword|application/doc|application/text|application/vnd.msword|application/vnd.ms-word|application/winword|application/word|application/x-msw6|application/x-msword', 'Word Document', 1);
INSERT INTO mimetypes VALUES (13, 'dxr', 'application/x-director|application/vnd.dxr', 'Macromedia Director Protected Movie File', 1);
INSERT INTO mimetypes VALUES (14, 'eps', 'application/eps|application/postscript|application/x-eps|image/eps|image/x-eps', 'Encapsulated PostScript', 1);
INSERT INTO mimetypes VALUES (15, 'gif', 'image/gif|image/x-xbitmap|image/gi_', 'Graphic Interchange Format', 1);
INSERT INTO mimetypes VALUES (16, 'gtar', 'application/x-gtar', 'GNU tar Compressed File Archive', 1);
INSERT INTO mimetypes VALUES (17, 'hqx', 'application/binhex|application/mac-binhex|application/mac-binhex40', 'Macintosh BinHex 4 Compressed Archive', 1);
INSERT INTO mimetypes VALUES (18, 'htm', 'text/html', 'Hypertext Markup Language', 1);
INSERT INTO mimetypes VALUES (19, 'html', 'text/html|text/plain', 'Hypertext Markup Language', 1);
INSERT INTO mimetypes VALUES (20, 'ico', 'image/ico|image/x-icon|application/ico|application/x-ico|application/x-win-bitmap|image/x-win-bitmap|application/octet-stream', 'Windows Icon', 1);
INSERT INTO mimetypes VALUES (21, 'jpe', 'image/jpeg', 'JPEG/JIFF Image', 1);
INSERT INTO mimetypes VALUES (22, 'jpeg', 'image/jpeg|image/jpg|image/jpe_|image/pjpeg|image/vnd.swiftview-jpeg', 'JPEG/JIFF Image', 1);
INSERT INTO mimetypes VALUES (23, 'jpg', 'image/jpeg|image/jpg|image/jp_|application/jpg|application/x-jpg|image/pjpeg|image/pipeg|image/vnd.swiftview-jpeg|image/x-xbitmap', 'JPEG/JIFF Image', 1);
INSERT INTO mimetypes VALUES (24, 'latex', 'application/x-latex|text/x-latex', 'LaTeX Source Document', 1);
INSERT INTO mimetypes VALUES (25, 'lha', 'application/lha|application/x-lha|application/octet-stream|application/x-compress|application/x-compressed|application/maclha', 'Compressed Archive File', 1);
INSERT INTO mimetypes VALUES (26, 'lzh', 'application/lzh|application/x-lzh|application/x-lha|application/x-compress|application/x-compressed|application/x-lzh-archive|application/zz-winassoc-lzh|application/maclha|application/octet-stream', 'Compressed Archive File', 1);
INSERT INTO mimetypes VALUES (27, 'm3u', 'audio/x-mpegurl|audio/mpeg-url|application/x-winamp-playlist|audio/scpls|audio/x-scpls', 'MP3 Playlist File', 1);
INSERT INTO mimetypes VALUES (28, 'mid', 'audio/mid|audio/m|audio/midi|audio/x-midi|application/x-midi|audio/soundtrack', 'Musical Instrument Digital Interface MIDI-sequention Sound', 1);
INSERT INTO mimetypes VALUES (29, 'midi', 'audio/mid|audio/m|audio/midi|audio/x-midi|application/x-midi', 'Musical Instrument Digital Interface MIDI-sequention Sound', 1);
INSERT INTO mimetypes VALUES (30, 'mov', 'video/quicktime|video/x-quicktime|image/mov|audio/aiff|audio/x-midi|audio/x-wav|video/avi', 'QuickTime Video Clip', 1);
INSERT INTO mimetypes VALUES (31, 'movie', 'video/sgi-movie|video/x-sgi-movie', 'QuickTime Movie', 1);
INSERT INTO mimetypes VALUES (32, 'mp2', 'video/mpeg|audio/mpeg', 'MPEG Audio Stream, Layer II', 1);
INSERT INTO mimetypes VALUES (33, 'mp3', 'audio/mpeg|audio/x-mpeg|audio/mp3|audio/x-mp3|audio/mpeg3|audio/x-mpeg3|audio/mpg|audio/x-mpg|audio/x-mpegaudio', 'MPEG Audio Stream, Layer III', 1);
INSERT INTO mimetypes VALUES (34, 'mpe', 'video/mpeg', 'MPEG Movie Clip', 1);
INSERT INTO mimetypes VALUES (35, 'mpeg', 'video/mpeg', 'MPEG Movie', 1);
INSERT INTO mimetypes VALUES (36, 'mpg', 'video/mpeg|video/mpg|video/x-mpg|video/mpeg2|application/x-pn-mpg|video/x-mpeg|video/x-mpeg2a|audio/mpeg|audio/x-mpeg|image/mpg', 'MPEG 1 System Stream', 1);
INSERT INTO mimetypes VALUES (37, 'mpga', 'audio/mpeg|audio/mp3|audio/mgp|audio/m-mpeg|audio/x-mp3|audio/x-mpeg|audio/x-mpg|video/mpeg', 'Mpeg-1 Layer3 Audio Stream', 1);
INSERT INTO mimetypes VALUES (38, 'pdf', 'application/pdf|application/acrobat|application/x-pdf|application/vnd.pdf|text/pdf', 'Acrobat Portable Document Format', 1);
INSERT INTO mimetypes VALUES (39, 'png', 'image/png|application/png|application/x-png', 'Portable (Public) Network Graphic', 1);
INSERT INTO mimetypes VALUES (40, 'ps', 'application/postscript|application/ps|application/x-postscript|application/x-ps|text/postscript', 'PostScript', 1);
INSERT INTO mimetypes VALUES (41, 'qt', 'video/quicktime|audio/aiff|audio/x-wav|video/flc', 'QuickTime Movie', 1);
INSERT INTO mimetypes VALUES (42, 'ra', 'audio/vnd.rn-realaudio|audio/x-pn-realaudio|audio/x-realaudio|audio/x-pm-realaudio-plugin|video/x-pn-realvideo', 'RealMedia Streaming Media', 1);
INSERT INTO mimetypes VALUES (43, 'ram', 'audio/x-pn-realaudio|audio/vnd.rn-realaudio|audio/x-pm-realaudio-plugin|audio/x-pn-realvideo|audio/x-realaudio|video/x-pn-realvideo|text/plain', 'RealMedia Metafile', 1);
INSERT INTO mimetypes VALUES (44, 'rar', 'application/octet-stream', 'WinRAR Compressed Archive', 1);
INSERT INTO mimetypes VALUES (45, 'rm', 'application/vnd.rn-realmedia|audio/vnd.rn-realaudio|audio/x-pn-realaudio|audio/x-realaudio|audio/x-pm-realaudio-plugin', 'RealMedia Streaming Media', 1);
INSERT INTO mimetypes VALUES (46, 'rpm', 'audio/x-pn-realaudio|audio/x-pn-realaudio-plugin|audio/x-pnrealaudio-plugin|video/x-pn-realvideo-plugin|audio/x-mpegurl|application/octet-stream', 'RealMedia Player Plug-in', 1);
INSERT INTO mimetypes VALUES (47, 'rtf', 'application/rtf|application/x-rtf|text/rtf|text/richtext|application/msword|application/doc|application/x-soffice', 'Rich Text Format File', 1);
INSERT INTO mimetypes VALUES (48, 'sit', 'application/stuffit|application/x-stuffit|application/x-sit', 'StuffIt Compressed Archive File', 1);
INSERT INTO mimetypes VALUES (49, 'smi', 'application/smil', 'SMIL Multimedia', 1);
INSERT INTO mimetypes VALUES (50, 'smil', 'application/smil', 'Synchronized Multimedia Integration Language', 1);
INSERT INTO mimetypes VALUES (51, 'snd', 'audio/basic', 'Macintosh Sound Resource', 1);
INSERT INTO mimetypes VALUES (52, 'spl', 'application/x-futuresplash', 'Macromedia FutureSplash File', 1);
INSERT INTO mimetypes VALUES (53, 'swf', 'application/x-shockwave-flash|application/x-shockwave-flash2-preview|application/futuresplash|image/vnd.rn-realflash', 'Macromedia Flash Format File', 1);
INSERT INTO mimetypes VALUES (54, 'tar', 'application/tar|application/x-tar|application/x-gtar|multipart/x-tar|application/x-compress|application/x-compressed', 'Tape Archive File', 1);
INSERT INTO mimetypes VALUES (55, 'tex', 'application/x-tex', 'LaTeX Source', 1);
INSERT INTO mimetypes VALUES (56, 'texi', 'application/x-texinfo', 'TeX', 1);
INSERT INTO mimetypes VALUES (57, 'texinfo', 'application/x-texinfo', 'TeX', 1);
INSERT INTO mimetypes VALUES (58, 'tif', 'image/tif|image/x-tif|image/tiff|image/x-tiff|application/tif|application/x-tif|application/tiff|application/x-tiff', 'Tagged Image Format File', 1);
INSERT INTO mimetypes VALUES (59, 'tiff', 'image/tiff', 'Tagged Image Format File', 1);
INSERT INTO mimetypes VALUES (60, 'ttf', 'image/ttf|text/ttf|application/ttf', 'True Type Fonts', 1);
INSERT INTO mimetypes VALUES (61, 'txt', 'text/plain|application/txt|browser/internal', 'Text File', 1);
INSERT INTO mimetypes VALUES (62, 'wav', 'audio/wav|audio/x-wav|audio/wave|audio/x-pn-wav', 'Waveform Audio', 1);
INSERT INTO mimetypes VALUES (63, 'wax', '|audio/x-ms-wax', 'Windows Media Audio Redirector', 1);
INSERT INTO mimetypes VALUES (64, 'wbmp', 'image/vnd.wap.wbmp', 'Wireless Bitmap File Format', 1);
INSERT INTO mimetypes VALUES (65, 'wm', 'video/x-ms-wm', 'Windows Media A/V File', 1);
INSERT INTO mimetypes VALUES (66, 'wma', 'audio/x-ms-wma|video/x-ms-asf', 'Windows Media Audio File', 1);
INSERT INTO mimetypes VALUES (67, 'wmd', 'application/x-ms-wmd', 'Windows Media Download File', 1);
INSERT INTO mimetypes VALUES (68, 'wml', 'text/vnd.wap.wml|text/wml', 'Website META Language File', 1);
INSERT INTO mimetypes VALUES (69, 'wmlc', 'application/vnd.wap.wmlc', 'Compiled WML Document', 1);
INSERT INTO mimetypes VALUES (70, 'wmls', 'text/vnd.wap.wmlscript', 'WML Script', 1);
INSERT INTO mimetypes VALUES (71, 'wmlsc', 'application/vnd.wap.wmlscriptc', 'Compiled WML Script', 1);
INSERT INTO mimetypes VALUES (72, 'wmv', 'video/x-ms-wmv', 'Windows Media File', 1);
INSERT INTO mimetypes VALUES (73, 'wmx', 'video/x-ms-wmx', 'Windows Media Player A/V Shortcut', 1);
INSERT INTO mimetypes VALUES (74, 'wmz', 'application/x-ms-wmz', 'Windows Media Compressed Skin File', 1);
INSERT INTO mimetypes VALUES (75, 'wvx', 'video/x-ms-wvx', 'Windows Media Redirector', 1);
INSERT INTO mimetypes VALUES (76, 'xht', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 1);
INSERT INTO mimetypes VALUES (77, 'xhtml', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 1);
INSERT INTO mimetypes VALUES (78, 'xml', 'text/xml|application/xml|application/x-xml', 'Extensible Markup Language File', 1);
INSERT INTO mimetypes VALUES (79, 'xsl', 'text/xml', 'XML Stylesheet', 1);
INSERT INTO mimetypes VALUES (80, 'zip', 'application/zip|application/x-zip|application/x-zip-compressed|application/octet-stream|application/x-compress|application/x-compressed|multipart/x-zip', 'Compressed Archive File', 1);


#
# Structure de la table 'mimetypes_perms'
#

CREATE TABLE mimetypes_perms (
  mperm_id int(10) NOT NULL auto_increment,
  mperm_mime mediumint(8) NOT NULL,
  mperm_module smallint(5) NOT NULL,
  mperm_groups smallint(5) NOT NULL,
  mperm_status int(1) NOT NULL default '0',
  mperm_maxwidth smallint(3) NOT NULL default '0',
  mperm_maxheight smallint(3) NOT NULL default '0',
  mperm_maxsize int(8) NOT NULL default '0',
  PRIMARY KEY  (mperm_id),
  KEY mime (mperm_mime),
  KEY module (mperm_module)
) TYPE=InnoDB;

#
# Contenu de la table mimetypes_perms
#

INSERT INTO mimetypes_perms VALUES ( 1,  8, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 2,  8, 1, 2, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 3, 15, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 4, 15, 1, 2, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 5, 21, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 6, 21, 1, 2, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 7, 22, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 8, 22, 1, 2, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES ( 9, 23, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES (10, 23, 1, 2, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES (11, 39, 1, 1, 1, 80, 80, 35000);
INSERT INTO mimetypes_perms VALUES (12, 39, 1, 2, 1, 80, 80, 35000);
