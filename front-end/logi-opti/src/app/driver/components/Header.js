'use client';
import { useState } from "react";
import * as React from 'react';
import Titre from "./Titre";
import Link from 'next/link';

export default function Header() {

    const [showNavbar, setShowNavbar] = useState(false)

    const handleShowNavbar = () => {
        setShowNavbar(!showNavbar)
    }

    return (
        <>
        <header className="flex justify-between w-full  px-5 pt-5 relative z-20">
            <div className="w-2/12 flex justify-start items-start">
                <img onClick={handleShowNavbar} className="w-6/12 h-10" src="/icons/BurgerMenu.png" alt="BurgerMenu" />
            </div>
            
            <div className="w-6/12 mt-6 flex justify-center">
                <img className="w-12/12" src="/logo.png" alt="Logo" />
            </div>

            <div className="flex w-3/12 items-start justify-end gap-2">
                <img className=" h-7" src="/icons/notifs.png" alt="Notifs" />
                <Link href="/driver/compte"><img className=" h-7" src="/icons/user.png" alt="User" /></Link>
            </div>

            <div className={`w-full absolute top-0 left-0 ${showNavbar ? 'navbar-show' : 'navbar-hide'}`}>
                    <div className="w-full bg-white pt-10 pl-10 pr-5 rounded-b-lg absolute top-0 left-0 z-30" id="myLinks">
                        <div className="flex justify-between mb-10">
                            <Titre page="Navigation" />
                            <img className="w-5/12" src="/logo.png" alt="Logo de LogiOpti" />
                        </div>
                        <div className="mb-10">
                            <div className="u-semi mb-2">
                                <h1 className="text-2xl hover:text-redFull"><Link href="/driver">Trajets </Link></h1>
                                
                            </div>
                            <div className="u-semi">
                                <h1 className="text-2xl hover:text-redFull"><Link href="/driver/itineraires">Itinéraire</Link></h1>

                            </div>
                        </div>
                        <div className="flex justify-end gap-3 pb-5 pr-1">
                            <Link href="/driver/compte"><img className=" h-7" src="/icons/user.png" alt="User" /></Link>
                        </div>
                    </div>
                    <div onClick={handleShowNavbar} className="h-screen bg-black opacity-30 z-20">
                        
                    </div>
                </div>
                
            
        </header>
        </>
    );

}