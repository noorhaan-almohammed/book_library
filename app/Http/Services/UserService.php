<?PHP

namespace App\Http\Services;

use App\Models\User;

class UserService{
    public function getAllUsers(){
       return User::get();

    }
    public function getUser(User $user){
        return $user;
    }

    function createUser(array $user){
       $user['password'] = bcrypt($user['password']);
       return User::create($user);
    }

    public function updateUser(array $data , User $user){
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return  $user->update($data);
    }
    public function deleteUser(User $user){
        $user->delete();
    }
}
