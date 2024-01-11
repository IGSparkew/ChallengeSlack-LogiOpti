<?php 
namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;

class AuthentificationMiddleware {

    public const ROLE_DRIVER = "ROLE_DRIVER";
    public const ROLE_OFFICE = "ROLE_OFFICE";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    
    public function verify(Request $request): bool {
        if ($request != null) {
            $authorizationHeader = $request->headers->get('Authorization');
            if ($authorizationHeader != null) {
                $headerPart = explode(" ",$authorizationHeader);
                $roles = $this->getRoleFromToken($headerPart);
                foreach($roles as $role) {
                    if ($role == $this::ROLE_DRIVER || $role == $this::ROLE_OFFICE || $role == $this::ROLE_ADMIN) {
                        return true;
                    }
                }
                
            }
        }

        return false;
    }

    public function getRole(Request $request) {
        if ($request != null) {
            $authorizationHeader = $request->headers->get('Authorization');

            if ($authorizationHeader != null) {
                $headerPart = explode(" ", $authorizationHeader);
                $roles = $this->getRoleFromToken($headerPart);
                if (!empty($roles)) {
                    return $roles;
                }
            }
        }

        return [];
    }

    public function checkRole(Request $request, $roleVerified) {
        $isVerified = $this->verify($request);
        if ($isVerified) {
            $roles = $this->getRole($request);
            foreach($roles as $role) {
                if ($role == $roleVerified) {
                    return true;
                }
            }
        }

        return false;
    }

    public function checkIfUserDriver(Request $request) {
        return $this->checkRole($request, $this::ROLE_DRIVER);
    }


    public function checkIfUserOffice(Request $request) {
        return $this->checkRole($request, $this::ROLE_OFFICE);
    }


    public function checkIfUserAdmin(Request $request) {
        return $this->checkRole($request, $this::ROLE_ADMIN);
    }

    private function decodePayload($headerToken) {
        if (empty($headerToken)) return null;
        $tokenparts = explode(".", $headerToken[1]);
        $tokenpayload = base64_decode($tokenparts[1]);
        return json_decode($tokenpayload);
    }

    private function getRoleFromToken($headerToken): array {
        if (empty($headerToken)) return [];
        $jwtPayload = $this->decodePayload($headerToken);
        if ($jwtPayload == null) return [];
        return $jwtPayload->roles;
    }


}



?>