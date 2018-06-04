<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Nette\Utils\Random;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Utils\Strings;
use App\Model\ProfileManager;
use App\Model\BaseManager;
use App\Model\PictureManager;
use Nette\Database\Context;
use App\Model\LevelManager;

/**
 * Users management.
 */
class UserManager extends BaseManager implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	const
		TABLE_NAME = 'users',
		COLUMN_ID = 'users_id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_EMAIL = 'email',
		COLUMN_ROLE = 'user_role_id',
                COLUMN_LEVEL = 'user_level_id',
                COLUMN_PROFILE_ID = 'profiles_id',
                COLUMN_TOKEN = 'token',
                COLUMN_EXPIRED = 'expired',
                COLUMN_LOCKED = 'locked',
                COLUMN_POINTS = 'points',
                
                TABLE_ROLES = 'user_role',
                COLUMN_ROLE_ID = 'user_role_id',
                COLUMN_ROLE_NAME = 'name',
                COLUMN_ROLE_V_NAME = 'view_name';


	/** @var Nette\Database\Context */	       
        private $profileManager;
        
        public $email;
        
        public $passwordLength;
        
        private $tokenValidity;
        
        private $emailText;
        
        private $levelManager;
       

	public function __construct($email,$tokenValidity,$passLength,$emailText,
                Context $database, PictureManager $picMan,
                ProfileManager $profileManager, LevelManager $levelMan)
	{
                parent::__construct($database, $picMan);
                $this->profileManager = $profileManager;   
                $this->email = $email;
                $this->passwordLength = $passLength;
                $this->tokenValidity = $tokenValidity;
                $this->emailText = $emailText;
                $this->levelManager = $levelMan;
                
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$user = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

		if (!$user) {
                    throw new Nette\Security\AuthenticationException('Uživatel s tímto jménem neexistuje.', self::IDENTITY_NOT_FOUND);
		}
                elseif (!Passwords::verify($password, $user[self::COLUMN_PASSWORD_HASH])) {
                    throw new Nette\Security\AuthenticationException('Zadané heslo není správné.', self::INVALID_CREDENTIAL);
		}
                elseif($user->locked == 1){
                    throw new Nette\Security\AuthenticationException('Váš účet byl zablokován.', self::NOT_APPROVED);
                }
                elseif (Passwords::needsRehash($user[self::COLUMN_PASSWORD_HASH])) {
			$user->update([
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			]);
		}

		$userData = $user->toArray();
		unset($userData[self::COLUMN_PASSWORD_HASH]);
                $role = $user->ref('user_role','user_role_id');               
		return new Nette\Security\Identity($user[self::COLUMN_ID],$role['name'] , $userData);
	}


	/**
	 * Adds new user.
	 * @param  string
	 * @param  string
	 * @param  string
	 * @return void
	 * @throws DuplicateNameException
	 */
	public function register($username, $email, $password)
	{
            $this->database->beginTransaction();
		try {
			$row = $this->database->table(self::TABLE_NAME)->insert([
				self::COLUMN_NAME => $username,
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
				self::COLUMN_EMAIL => $email,                                                         
			]);
                        
                        $id = $row->getPrimary();
                        
                        $this->profileManager->createProfile($id);                                                
                        $this->database->commit();
                        return $id;
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
                    
                        $this->database->rollBack();
			//throw new DuplicateNameException;
                        if(Strings::endsWith($e->getMessage(),"email'")){
                            throw new DuplicateEmailException;
                        }
                        else{
                            throw new DuplicateNameException;
                        }
                        
		}
	}
        
        public function getUserByToken($token){
            $user = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_TOKEN, $token)
                        ->fetch();
            return $user;
        }
        
        public function getUser($userId){
            $user = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_ID, $userId)
                        ->fetch();
            return $user;
        }
               
        public function changeData($userData){            
            $email = $this->changeEmail($userData);
            $name = $this->changeName($userData);
            $password = $this->changePassword($userData);
            
            $data = array_merge($email,$name,$password);
            try {
                $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userData[self::COLUMN_ID])
                    ->update($data);            
            }
            catch(Nette\Database\UniqueConstraintViolationException $e){
                if(Strings::endsWith($e->getMessage(),"email'")){
                    throw new DuplicateEmailException;
                }
                else{
                    throw new DuplicateNameException;
                }
            }
        }
        
        private function changeEmail($userData){
            
            if($userData[self::COLUMN_EMAIL]){
               
                return [self::COLUMN_EMAIL => $userData[self::COLUMN_EMAIL]];
            }
            else{
                
                return [];
            }
          
        }
        
        private function changeName($userData){
            
            if($userData[self::COLUMN_NAME]){
                return [self::COLUMN_NAME => $userData[self::COLUMN_NAME]];
            }
            else{
                return [];
            }
        }
        
        private function changePassword($userData){
            
            $userId = $userData[self::COLUMN_ID];
            $user = $this->getUserAll($userId);            
            if($userData['old_password'] || $userData['new_password']){
              if(Passwords::verify($userData['old_password'], $user[self::COLUMN_PASSWORD_HASH])){
                  
                  $newPassword = Passwords::hash($userData['new_password']);
                  return [self::COLUMN_PASSWORD_HASH => $newPassword];
              }
              else{
                  throw new Nette\Security\AuthenticationException('Zadané staré heslo není správné.', self::INVALID_CREDENTIAL);
              }
                
            }
            
            return [];
            
        }
        
        private function changeToken($data){
            $this->database->table(self::TABLE_NAME)
                           ->where(self::COLUMN_ID,$data[self::COLUMN_ID])
                           ->update($data);
        }
        
        private function getUserAll($userId){
          return  $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->fetch();
        }        
       
        public function getFiltreItems($parameters){ 
            
            $users = $this->database->table(self::TABLE_NAME);
            
            if(!empty($parameters['namesearch'])){
                
               $users->where(self::COLUMN_NAME . ' LIKE','%'.$parameters['namesearch'].'%');
            }
            
             if(!empty($parameters['emailsearch'])){
                
               $users->where(self::COLUMN_EMAIL . ' LIKE','%'.$parameters['emailsearch'].'%');
            }
            
            if(!empty($parameters['role'])){
                if($parameters['role'] != 0){
                    $users->where(self::COLUMN_ROLE_ID,$parameters['role']);
                } 
            }
            
            if(isset($parameters['lock'])){
                if($parameters['lock'] != 3){
                    $users->where(self::COLUMN_LOCKED,$parameters['lock']);
                } 
            }
           
          
            $orderUsers = parent::order($users,self::TABLE_NAME,$parameters);         
            return $orderUsers;
        }
        
        public function deleteUser($userId){
           
           $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)          
                    ->delete(); 
                   
           $this->profileManager->deleteProfile($userId);           
        }
        
        public function changeRole($userId,$roleId){
            
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->update([self::COLUMN_ROLE => $roleId]);
        }
        
        private function lockUser($userId){
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->update([self::COLUMN_LOCKED => 1]);                    
        }
        
        private function unlockUser($userId){
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->update([self::COLUMN_LOCKED => 0]);                    
        }
        
        public function toggleLock($userId){
            $lock = $this->database->table(self::TABLE_NAME)
                    ->select(self::COLUMN_LOCKED)
                    ->where(self::COLUMN_ID,$userId)
                    ->fetch();
            if($lock->locked == 1){
               $this->unlockUser($userId);
            }
            else{
               $this->lockUser($userId);
            }
        }
        
        public function getRoles(){         
                  
         $roles =    $this->database->table(self::TABLE_ROLES)
                    ->select(self::COLUMN_ROLE_ID . ', ' . self::COLUMN_ROLE_V_NAME )
                    ->fetchPairs(self::COLUMN_ROLE_ID,self::COLUMN_ROLE_V_NAME);
         
         return $roles;
        }
        
        public function sendToken($email,$template){
            $user = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_EMAIL,$email)
                        ->fetch();
           if($user){
               $token = Random::generate(7);
               $hash = Passwords::hash($token);
               $template->token = $hash;
               $template->text = $this->emailText;
               $mail = new Message();              
               $mail->setFrom($this->email)
                    ->addTo($email)                    
                    ->setSubject('Změna hesla')
                    ->setHtmlBody($template)
                    ->setBody($hash);                      
               $mailer = new SendmailMailer;
               $mailer->send($mail);
               
               $date = strtotime($this->tokenValidity .' day');
               $expired = date('Y-m-d', $date);
               $data = [self::COLUMN_ID => $user[self::COLUMN_ID],
                        self::COLUMN_TOKEN => $hash,
                        self::COLUMN_EXPIRED => $expired];
               
               $this->changeToken($data);
            
           }
        }
        
        public function resetPassword($data){
            if($data['password'] == $data['password_check']){
                $hash = Passwords::hash($data['password']);
                $this->database->table(self::TABLE_NAME)
                                ->where(self::COLUMN_ID,$data[self::COLUMN_ID])
                                ->update([self::COLUMN_PASSWORD_HASH => $hash,
                                          self::COLUMN_TOKEN => '',
                                          self::COLUMN_EXPIRED => '0000-00-00']);
            }
        }      
        
        public function renewIdentity($userId){
            $user = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->fetch();
           $userData = $user->toArray();
           unset($userData[self::COLUMN_PASSWORD_HASH]);
           $role = $user->user_role->name;
           return $identity = new Nette\Security\Identity($user[self::COLUMN_ID],$role,$userData);
            
        }
        
        public function checkToken($changingUser){
            return $changingUser && $changingUser[self::COLUMN_EXPIRED] >= date('Y-m-d');
        }
        
        public function changePoints($userId,$add){            
            $user = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_ID,$userId);
            
            $points = $user->select(self::COLUMN_POINTS)->fetch()[self::COLUMN_POINTS];            
            $newPoints = $points + $add;
            
            $user->update([self::COLUMN_POINTS => $newPoints]);
            $this->setLevel($userId, $newPoints);
        }
        
        private function setLevel($userId,$points){
            $levelId = $this->levelManager->getLevelId($points);
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$userId)
                    ->update([self::COLUMN_LEVEL => $levelId]);
        }
        
        public function updateAllLevels(){
            $users = $this->database->table(self::TABLE_NAME)
                     ->fetchAll();
            $saveArray = [];
            $updateArray = [];
            foreach($users as $user){
                $points = $user[self::COLUMN_POINTS];
                $values = [self::COLUMN_ID => $user[self::COLUMN_ID],
                           self::COLUMN_LEVEL => $this->levelManager->getLevelId($points)
                         ];
                $saveArray[] = $values;
            }
            $key = self::COLUMN_LEVEL;
            $updateArray[$key] = new Nette\Database\SqlLiteral("VALUES($key)");
            
            $this->database->query('INSERT INTO '.self::TABLE_NAME,$saveArray, 'ON DUPLICATE KEY UPDATE ', $updateArray);
        }
        
        public function getRank($userId){
            $user = $this->getUser($userId);
            $points = $user[self::COLUMN_POINTS];
            
            $better = $this->database->table(self::TABLE_NAME)                            
                            ->where(self::COLUMN_POINTS . '>', $points)
                            ->count();
            
            $same = $this->database->table(self::TABLE_NAME)                            
                            ->where(self::COLUMN_POINTS, $points)
                            ->count();
            $rank = $better == 0 && $same == 0 ? '1.' : $same == 1 ? ($better + 1).'.' : ($better + 1) .'-'. ($better + $same).'.';
            
            return $rank;
        }
        
        public function getRanks($limit, $offset){
       
          return $this->database->query('SELECT *, (SELECT COUNT(*) FROM users WHERE points > t1.points) as better, (SELECT COUNT(*) FROM users WHERE points = t1.points) as same FROM users AS t1 ORDER BY points DESC LIMIT  ? OFFSET ?',$limit,$offset)
                  ->fetchAll();
        }
        
        public function getUserCount(){
            return $this->database->table(self::TABLE_NAME)
                    ->count();
        }
        
        
        public function getUser2($userId){
            $userParameters = [];
            $user = $this->getUser($userId);
            $profile = $user->ref('profiles','users_id');
            $level = $user->ref('user_level','user_level_id');
            $role = $user->ref('user_role','user_role_id');
            
            $userParameters['username'] = $user[self::COLUMN_NAME];
            $userParameters['role'] = $role['name'];
            $userParameters['points'] = $user[self::COLUMN_POINTS];
            $userParameters['level_name'] = $level['name'];
            $userParameters['level_max_points'] = $level['max_points'];
            $userParameters['points_next_level'] = ($level['max_points'] - $user['points']) + 1;
            
            return $userParameters;
        }

}

class DuplicateNameException extends \Exception{
    /** Konstruktor s definicích výchozí chybové zprávy. */
        public function __construct()
        {
                parent::__construct();
                $this->message = 'Uživatel s tímto jménem je již zaregistrovaný.';
        }
}

class DuplicateEmailException extends \Exception{
    /** Konstruktor s definicích výchozí chybové zprávy. */
        public function __construct()
        {
                parent::__construct();
                $this->message = 'Uživatel s tímto emailem je již zaregistrovaný.';
        }
}
