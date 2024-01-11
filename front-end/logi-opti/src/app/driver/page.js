
'use client'
import DerniersTrajets from "./components/DerniersTrajets";
import TrajetsAVenir from "./components/TrajetsAVenir";
import Header from "./components/Header";
import ModalArrivee from "./components/ModalArrivee";
import ModalDetails from "./components/ModalDetails";
import ModalAjoutUpdate from "./components/ModalAjoutUpdate";
import Titre from "./components/Titre";
import { useState, useEffect } from "react";
import { isDriverUser } from "../middleware/authMiddleware";
import { useRouter } from "next/navigation";

export default function Driver() {

    const [openDetails,setOpenDetails] = useState(false);
    const [openArrivee,setOpenArrivee] = useState(false);
    const [openAjout,setOpenAjout] = useState(false);
    const [openUpdate,setOpenUpdate] = useState(false);

    const router = useRouter();

    const handleSetOpenDetails = (data) => {
        setOpenDetails(data);
    }
    const handleSetOpenArrivee = (data) => {
        setOpenArrivee(data);
    }
    const handleSetOpenAjout = (data) => {
        setOpenAjout(data);
    }
    const handleSetOpenUpdate = (data) => {
        setOpenUpdate(data);
    }

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
    }, []);

    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Trajets"/>
                <TrajetsAVenir setOpenArrivee={handleSetOpenArrivee} setOpenAjout={handleSetOpenAjout} setOpenUpdate={handleSetOpenUpdate} setOpenDetails={handleSetOpenDetails}/>
                <DerniersTrajets setOpen= {handleSetOpenDetails}/>
            </div>

            <ModalArrivee openArrivee={openArrivee} setOpenArrivee={setOpenArrivee}/>
            <ModalDetails openDetails={openDetails} setOpenDetails={setOpenDetails}/>
            <ModalAjoutUpdate openAjout={openAjout} openUpdate={openUpdate} setOpenAjout={setOpenAjout} setOpenUpdate={setOpenUpdate}/>
        </main>
    );
}