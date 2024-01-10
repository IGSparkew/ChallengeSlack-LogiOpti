export default function Header() {
    return (
        <header className="flex justify-between w-full  px-5 pt-5">
            <div className="w-2/12 flex justify-start items-start">
                <img className="w-6/12 h-10" src="icons/BurgerMenu.png" alt="BurgerMenu" />
            </div>
            
            <div className="w-6/12 mt-6 flex justify-center">
                <img className="w-12/12" src="logo.png" alt="Logo" />
            </div>

            <div className="flex w-3/12 items-start justify-end gap-2">
                <img className=" h-7" src="icons/notifs.png" alt="Notifs" />
                <img className=" h-7" src="icons/user.png" alt="User" />
            </div>
        </header>
    );

}