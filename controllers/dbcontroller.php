<?php

set_include_path('/home/storage/3/77/4f/voat/public_html/sociallodge:/home/storage/3/77/4f/voat/public_html/sociallodge/model:/home/storage/3/77/4f/voat/public_html/sociallodge/controllers:/home/storage/3/77/4f/voat/public_html/sociallodge/Utils');

require_once('User.php');
require_once('Topic.php');
require_once('News.php');
require_once('TopicMessage.php');
require_once('Degree.php');
require_once('SocialNetworkInstance.php');
require_once('SocialNetwork.php');
require_once('GoverningBody.php');
require_once('Document.php');
require_once('Lodge.php');
require_once('Album.php');

class DBController {

    private $link = null;

    function __construct() {

        $this->link = mysql_connect('186.202.152.144', 'voat8', 'uala34');
        if (!$this->link) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('voat8');
    }

    function __destruct() {
        mysql_close($this->link);
    }

    public function login($governingBodyId, $login, $password)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, governing_body_id, lodge_id, degree_id, cim, profile_picture, name, email, address, phone, mobile, webpage, aboutme FROM users WHERE governing_body_id='".$governingBodyId."' AND cim='".$login."' AND password='".$password."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $governing_body_id = $row["governing_body_id"];
            $lodge_id = $row["lodge_id"];
            $degree_id = $row["degree_id"];
            $cim = $row["cim"];
            $profile_picture = $row["profile_picture"];
            $name = $row["name"];
            $email = $row["email"];
            $address = $row["address"];
            $phone = $row["phone"];
            $mobile = $row["mobile"];
            $webpage = $row["webpage"];
            $aboutme = $row["aboutme"];

            $user = new User($governing_body_id, $lodge_id, $degree_id, $cim, $profile_picture,
                $name, $email, $address, $phone, $mobile, $webpage, $aboutme);
            $user->setId($id);

            $ret = $user;
        }

        return $ret;
    }

    public function getUser($userId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT governing_body_id, lodge_id, degree_id, cim, profile_picture, name, email, address, phone, mobile, webpage, aboutme FROM users WHERE id='".$userId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $id = $userId;
            $governing_body_id = $row["governing_body_id"];
            $lodge_id = $row["lodge_id"];
            $degree_id = $row["degree_id"];
            $cim = $row["cim"];
            $profile_picture = $row["profile_picture"];
            $name = $row["name"];
            $email = $row["email"];
            $password = $row["password"];
            $address = $row["address"];
            $phone = $row["phone"];
            $mobile = $row["mobile"];
            $webpage = $row["webpage"];
            $aboutme = $row["aboutme"];

            $user = new User($governing_body_id, $lodge_id, $degree_id, $cim, $profile_picture,
                $name, $email, $address, $phone, $mobile, $webpage, $aboutme);
            $user->setId($id);
            $user->setPassword($password);

            $ret = $user;
        }

        return $ret;
    }

    public function getLodgeUsers($lodgeId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, governing_body_id, lodge_id, degree_id, cim, profile_picture, name, email, address, phone, mobile, webpage, aboutme FROM users WHERE lodge_id='".$lodgeId."' ORDER BY RAND()");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $governing_body_id = $row["governing_body_id"];
            $lodge_id = $row["lodge_id"];
            $degree_id = $row["degree_id"];
            $cim = $row["cim"];
            $profile_picture = $row["profile_picture"];
            $name = $row["name"];
            $email = $row["email"];
            $address = $row["address"];
            $phone = $row["phone"];
            $mobile = $row["mobile"];
            $webpage = $row["webpage"];
            $aboutme = $row["aboutme"];

            $user = new User($governing_body_id, $lodge_id, $degree_id, $cim, $profile_picture,
                              $name, $email, $address, $phone, $mobile, $webpage, $aboutme);
            $user->setId($id);

            $ret[] = $user;
        }

        return $ret;
    }

    public function getTopic($topicId)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT lodge_id, user_id, degree_id, subject, date_created, date_updated FROM topics WHERE id='".$topicId."' AND lodge_id='".$_SESSION['user_lodge_id']."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $id = $topicId;
            $lodge_id = $row["lodge_id"];
            $user_id = $row["user_id"];
            $degree_id = $row["degree_id"];
            $subject = $row["subject"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $topic = new Topic($lodge_id, $user_id, $degree_id, $subject, $date_created, $date_updated);
            $topic->setId($id);

            $ret = $topic;
        }

        return $ret;
    }

    public function getRecentTopics($degreeValue)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT t.id, t.lodge_id, t.user_id, t.degree_id, t.subject, t.date_created, t.date_updated FROM topics as t JOIN degrees as d ON d.id=t.degree_id WHERE t.lodge_id='".$_SESSION['user_lodge_id']."' AND d.value<='".$degreeValue."' ORDER BY date_updated DESC LIMIT 5");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];;
            $lodge_id = $row["lodge_id"];
            $user_id = $row["user_id"];
            $degree_id = $row["degree_id"];
            $subject = $row["subject"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $topic = new Topic($lodge_id, $user_id, $degree_id, $subject, $date_created, $date_updated);
            $topic->setId($id);

            $ret[] = $topic;
        }

        return $ret;
    }

    public function getTopics()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, lodge_id, user_id, degree_id, subject, date_created, date_updated FROM topics WHERE lodge_id='".$_SESSION['user_lodge_id']."' ORDER BY date_updated DESC");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];;
            $lodge_id = $row["lodge_id"];
            $user_id = $row["user_id"];
            $degree_id = $row["degree_id"];
            $subject = $row["subject"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $topic = new Topic($lodge_id, $user_id, $degree_id, $subject, $date_created, $date_updated);
            $topic->setId($id);

            $ret[] = $topic;
        }

        return $ret;
    }

    public function deleteTopicMessage($topicMessageId){
        return mysql_query("DELETE FROM topic_messages WHERE id='".$topicMessageId."'");
    }

    public function getTopicMessages($topicId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, user_id, date_and_time, message FROM topic_messages WHERE topic_id='".$topicId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $userId = $row["user_id"];
            $dateAndTime = $row["date_and_time"];
            $message = $row["message"];

            $topicMessage = new TopicMessage($topicId, $userId, $dateAndTime, $message);
            $topicMessage->setId($id);

            $ret[] = $topicMessage;
        }

        return $ret;
    }

    public function getDegreeById($degreeId)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT name, value FROM degrees WHERE id='".$degreeId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $id = $degreeId;
            $name = $row["name"];
            $value = $row["value"];

            $degree = new Degree($name, $value);
            $degree->setId($id);

            $ret = $degree;
        }

        return $ret;
    }

    public function getDegrees()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, name, value FROM degrees");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $name = $row["name"];
            $value = $row["value"];

            $degree = new Degree($name, $value);
            $degree->setId($id);

            $ret[] = $degree;
        }

        return $ret;
    }

    public function insertNewTopic($userId, $degreeId, $subject, $message)
    {
        $ret = 0;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT lodge_id FROM users WHERE id='".$userId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

//        $lodge_id = 0;
//        if($row = mysql_fetch_array($result))
//        {
//            $lodge_id = $row["lodge_id"];
//        }

        $result = mysql_query("SHOW TABLE STATUS LIKE 'topics'");
        $row = mysql_fetch_array($result);
        $topicId = $row['Auto_increment'];
        $now = date('Y-m-d G:i:s');

        $result = mysql_query("INSERT INTO topics (id, lodge_id, user_id, degree_id, subject, date_created, date_updated) VALUES('".$topicId."', '".$_SESSION['user_lodge_id']."', '".$userId."', '".$degreeId."', '".$subject."', '".$now."', '".$now."')");
        if($result)
        {
            $result = mysql_query("INSERT INTO topic_messages (topic_id, user_id, date_and_time, message) VALUES('".$topicId."', '".$userId."', '".$now."', '".mysql_real_escape_string($message, $this->link)."')");
            if($result){
                $ret = $topicId;
            }
        }

        return $ret;
    }

    public function updateTopic($topicId, $userId, $message)
    {
        $ret = false;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $now = date('Y-m-d G:i:s');
        $result = mysql_query("INSERT INTO topic_messages (topic_id, user_id, date_and_time, message) VALUES('".$topicId."', '".$userId."', '".$now."', '".mysql_real_escape_string($message, $this->link)."')");
        if($result)
        {
            $result = mysql_query("UPDATE topics SET date_updated='".$now."' WHERE id='".$topicId."'");
            if($result){
                $ret = true;
            }
        }

        return $ret;
    }

    public function getRecentNews()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, lodge_id, subject, contents, date_created, date_updated FROM news ORDER BY date_updated DESC LIMIT 5");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $lodge_id = $row["lodge_id"];
            $subject = $row["subject"];
            $contents = $row["contents"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $news = new News($lodge_id, $subject, $contents, $date_created, $date_updated);
            $news->setId($id);

            $ret[] = $news;
        }

        return $ret;
    }

    public function getNewsById($newsId)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT lodge_id, subject, contents, date_created, date_updated FROM news WHERE id='".$newsId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $id = $newsId;
            $lodge_id = $row["lodge_id"];
            $subject = $row["subject"];
            $contents = $row["contents"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $n = new News($lodge_id, $subject, $contents, $date_created, $date_updated);
            $n->setId($id);

            $ret = $n;
        }

        return $ret;
    }

    public function getNews()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, lodge_id, subject, contents, date_created, date_updated FROM news ORDER BY date_updated DESC");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];;
            $lodge_id = $row["lodge_id"];
            $subject = $row["subject"];
            $contents = $row["contents"];
            $date_created = $row["date_created"];
            $date_updated = $row["date_updated"];

            $n = new News($lodge_id, $subject, $contents, $date_created, $date_updated);
            $n->setId($id);

            $ret[] = $n;
        }

        return $ret;
    }

    public function getSocialNetworkInstances($userId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT usn.id, usn.social_network_id, sn.name, sn.icon, usn.value FROM users_social_networks as usn JOIN users as u ON usn.user_id=u.id JOIN social_networks as sn ON usn.social_network_id=sn.id WHERE u.id='".$userId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];;
            $socialNetworkId = $row["social_network_id"];
            $socialNetworkName = $row["name"];
            $socialNetworkIcon = $row["icon"];
            $link = $row["value"];

            $sni = new SocialNetworkInstance($userId, $socialNetworkId, $socialNetworkName, $socialNetworkIcon, $link);
            $sni->setId($id);

            $ret[] = $sni;
        }

        return $ret;
    }

    public function updateUserData($name, $email, $password, $address, $phone, $mobile, $webpage, $aboutme)
    {
        $ret = false;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        if(strlen ($password) == 0){
            $strQuery = "UPDATE users SET name='".$name."', email='".$email."', address='".$address."', phone='".$phone."', mobile='".$mobile."', webpage='".$webpage."', aboutme='".$aboutme."' WHERE id='".$_SESSION['user_id']."'";
        }
        else{
            $password = md5($password);
            $strQuery = "UPDATE users SET name='".$name."', email='".$email."', password='".$password."', address='".$address."', phone='".$phone."', mobile='".$mobile."', webpage='".$webpage."', aboutme='".$aboutme."' WHERE id='".$_SESSION['user_id']."'";
        }

        $result = mysql_query($strQuery);
        if($result){
            $ret = true;
        }

        return $ret;
    }

    public function getSocialNetworkValueFromUser($userId, $socialNetworkId)
    {
        /*"SELECT sn.name, usn.value FROM users_social_networks as usn
        JOIN social_networks as sn ON sn.id=usn.social_network_id
        WHERE usn.user_id='20'"*/

        $ret = "";

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT value FROM users_social_networks WHERE user_id='".$userId."' AND social_network_id='".$socialNetworkId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $ret = $row["value"];
        }

        return $ret;
    }

    public function getSocialNetworks()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, name, icon FROM social_networks");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];;
            $name = $row["name"];
            $icon = $row["icon"];

            $socialNetwork = new SocialNetwork($name, $icon);
            $socialNetwork->setId($id);

            $ret[] = $socialNetwork;
        }

        return $ret;
    }

    public function updateUserSocialNetwork($socialNetworkId, $value)
    {
        $ret = false;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id FROM users_social_networks WHERE user_id='".$_SESSION['user_id']."' AND social_network_id='".$socialNetworkId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        $num_rows = mysql_num_rows($result);
        if($num_rows == 0 && strlen($value) > 0)
        {
            $strQuery = "INSERT INTO users_social_networks (user_id, social_network_id, value) VALUES('".$_SESSION['user_id']."', '".$socialNetworkId."', '".$value."')";
            $result = mysql_query($strQuery);
            if($result){
                $ret = true;
            }
        }
        else
        {
            $strQuery = "UPDATE users_social_networks SET value='".$value."' WHERE user_id='".$_SESSION['user_id']."' AND social_network_id='".$socialNetworkId."'";
            $result = mysql_query($strQuery);
            if($result){
                $ret = true;
            }
        }

        return $ret;
    }

    public function getLodgeName()
    {
        $ret = "";

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT name FROM lodges WHERE id='".$_SESSION['user_lodge_id']."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        if($row = mysql_fetch_array($result))
        {
            $ret = $row["name"];
        }

        return $ret;
    }

    public function getGoverningBodies()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, name, address, description FROM governing_bodies");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $name = $row["name"];
            $address = $row["address"];
            $description = $row["description"];

            $gb = new GoverningBody($name, $address, $description);
            $gb->setId($id);

            $ret[] = $gb;
        }

        return $ret;
    }

    public function getDocuments()
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, name, filename, date_and_time FROM documents WHERE lodge_id='".$_SESSION['user_lodge_id']."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $lodgeId = $_SESSION['user_lodge_id'];
            $name = $row["name"];
            $filename = $row["filename"];
            $dateAndTime = $row["date_and_time"];

            $doc = new Document($lodgeId, $name, $filename, $dateAndTime);
            $doc->setId($id);

            $ret[] = $doc;
        }

        return $ret;
    }

    public function lodgesFromMemberId($memberId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT l.id, l.logo, l.governing_body_id, l.temple_id, l.number, l.name, l.description FROM lodges as l JOIN members_lodges as ml ON l.id=ml.lodge_id WHERE ml.user_id='".$memberId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $logo = $row["logo"];
            $governingBodyId = $row['governing_body_id'];
            $templeId = $row["temple_id"];
            $number = $row["number"];
            $name = $row["name"];
            $description = $row["description"];

            $lodge = new Lodge($logo, $governingBodyId, $templeId, $number, $name, $description);
            $lodge->setId($id);

            $ret[] = $lodge;
        }

        return $ret;
    }

    public function getMembersFromLodgeId($lodgeId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT u.id, u.governing_body_id, u.lodge_id, u.degree_id, u.cim, u.profile_picture, u.name, u.email, u.password, u.address, u.phone, u.mobile, u.webpage, u.aboutme FROM users as u JOIN lodge_members as lm ON u.id=lm.user_id WHERE lm.lodge_id='".$lodgeId."' ORDER BY RAND()");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $governing_body_id = $row["governing_body_id"];
            $lodge_id = $row["lodge_id"];
            $degree_id = $row["degree_id"];
            $cim = $row["cim"];
            $profile_picture = $row["profile_picture"];
            $name = $row["name"];
            $email = $row["email"];
            $address = $row["address"];
            $phone = $row["phone"];
            $mobile = $row["mobile"];
            $webpage = $row["webpage"];
            $aboutme = $row["aboutme"];

            $user = new User($governing_body_id, $lodge_id, $degree_id, $cim, $profile_picture,
                $name, $email, $address, $phone, $mobile, $webpage, $aboutme);
            $user->setId($id);

            $ret[] = $user;
        }

        return $ret;
    }

    public function getLodgeFromUser($userId)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT l.id, l.logo, l.governing_body_id, l.temple_id, l.number, l.name, l.description FROM lodges as l JOIN users as u ON l.id=u.lodge_id WHERE u.id='".$userId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $logo = $row["logo"];
            $governingBodyId = $row['governing_body_id'];
            $templeId = $row["temple_id"];
            $number = $row["number"];
            $name = $row["name"];
            $description = $row["description"];

            $lodge = new Lodge($logo, $governingBodyId, $templeId, $number, $name, $description);
            $lodge->setId($id);

            $ret = $lodge;
        }

        return $ret;
    }

    public function getLodgeById($lodgeId)
    {
        $ret = null;

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT logo, governing_body_id, temple_id, number, name, description FROM lodges WHERE id='".$lodgeId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $lodgeId;
            $logo = $row['logo'];
            $governingBodyId = $row['governing_body_id'];
            $templeId = $row["temple_id"];
            $number = $row["number"];
            $name = $row["name"];
            $description = $row["description"];

            $lodge = new Lodge($logo, $governingBodyId, $templeId, $number, $name, $description);
            $lodge->setId($id);

            $ret = $lodge;
        }

        return $ret;
    }

    public function getAlbumsFromUserId($userId)
    {
        $ret = array();

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        $result = mysql_query("SELECT id, main_pic_id, name FROM albums WHERE user_id='".$userId."'");

        if (!$result) {
            echo "An error occured.<br> Could not get records.\n";
            return false;
        }

        while($row = mysql_fetch_array($result))
        {
            $id = $row["id"];
            $main_pic_id = $row["main_pic_id"];
            $name = $row["name"];

            $album = new Album($userId, $main_pic_id, $name);
            $album->setId($id);

            $ret[] = $album;
        }

        return $ret;
    }

    public function getRoles($userId, $lodgeId)
    {
        $ret = array("worshipful_master_user_id" => false, "senior_warden_user_id" => false, "junior_warden_user_id" => false, "orator_user_id" => false, "secretary_user_id" => false, "treasurer_user_id" => false, "hospitable_user_id" => false, "chancellor_user_id" => false);

        if (!$this->link) {
            echo "Not connected.<br>\n";
            return false;
        }

        // Verify if user is Worshipful Master
        $result = mysql_query("SELECT id FROM lodges WHERE worshipful_master_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get worshipful_master_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["worshipful_master_user_id"] = true;
        }

        // Verify if user is Senior Warden
        $result = mysql_query("SELECT id FROM lodges WHERE senior_warden_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get senior_warden_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["senior_warden_user_id"] = true;
        }

        // Verify if user is Junior Warden
        $result = mysql_query("SELECT id FROM lodges WHERE junior_warden_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get junior_warden_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["junior_warden_user_id"] = true;
        }

        // Verify if user is Orator
        $result = mysql_query("SELECT id FROM lodges WHERE orator_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get orator_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["orator_user_id"] = true;
        }

        // Verify if user is Secretary
        $result = mysql_query("SELECT id FROM lodges WHERE secretary_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get secretary_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["secretary_user_id"] = true;
        }

        // Verify if user is Treasurer
        $result = mysql_query("SELECT id FROM lodges WHERE treasurer_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get treasurer_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["treasurer_user_id"] = true;
        }

        // Verify if user is Hospitable
        $result = mysql_query("SELECT id FROM lodges WHERE hospitable_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get treasurer_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["hospitable_user_id"] = true;
        }

        // Verify if user is Chancellor
        $result = mysql_query("SELECT id FROM lodges WHERE chancellor_user_id='".$userId."' and id='".$lodgeId."'");
        if (!$result) {
            echo "An error occured.<br> Could not get chancellor_user_id record.\n";
            return false;
        }
        if($row = mysql_fetch_array($result))
        {
            $ret["chancellor_user_id"] = true;
        }

        return $ret;
    }

}
?>
