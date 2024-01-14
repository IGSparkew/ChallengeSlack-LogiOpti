export default function TrajetsAVenir({setOpenArrivee,setOpenAjout,setOpenUpdate,setOpenDetails}) {


    const trajetRempli = false;
    const itineraire = true;

    return (
        <div className="flex flex-col gap-5 justify-center bg-white px-10 shadow-box py-5 relative z-10">
            <h2 className="u-semi text-xl underline text-center"> Trajet à venir</h2>
            {trajetRempli ? (
                <>
                    <div className="bg-slate-200 px-3 py-2">
                        <p className="text-xs u-r text-center">Trajet du 27/06 à 11H35 : Lyon - Berlin</p>
                    </div>
                    <div className="flex gap-3 justify-center"> 
                        <div onClick={()=>setOpenDetails(true)} className="px-10 py-2 bg-redFull rounded text-white u-semi hover:cursor-pointer">
                            <p>Détails</p>
                        </div>
                        <div onClick={() => setOpenUpdate(true)} className="px-10 py-2 border-2 rounded border-redFull text-redFull u-semi hover:cursor-pointer">
                            <p>Modifier</p>
                        </div>
                    </div>
                </>
            ) : itineraire ?(
                <>
                    <div className="bg-slate-200 px-3 py-2">
                        <p className="text-xs u-r">Trajet du 27/06 à 11H35 : Lyon - Berlin</p>
                    </div>

                    <div className="flex flex-col text-sm gap-4">
                        <div className="flex justify-between">
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Date d’arrivée</p>
                                <p>24/01/23 11H35</p>
                            </div>
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Type de véhicule</p>
                                <p>Renault Master</p>
                            </div>
                        </div>

                        <div className="flex justify-between">
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Cout du péage</p>
                                <p>26,90€</p>
                            </div>
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Cout de l’usure</p>
                                <p>26,90€</p>
                            </div>
                        </div>

                        <div className="flex justify-between">
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Distance parcourue</p>
                                <p>325 km</p>
                            </div>
                            <div className="flex flex-col gap-1">
                                <p className="u-semi underline">Durée du trajet</p>
                                <p>3h50</p>
                            </div>
                        </div>

                    </div>
                </>
                
            ): (
                <>
                    <div className="bg-slate-200 px-3 py-2 rounded-lg text-center">
                        <p className="text-xs u-r">Aucun trajet n’a été renseignée</p>
                    </div>
                    <div onClick={()=>setOpenAjout(true)} className="px-10 py-2 bg-redFull rounded  text-center text-white u-semi hover:cursor-pointer">
                        <p>Ajouter un trajet</p>
                    </div>
                </>
            )}
            
            <div onClick={() => setOpenArrivee(true)} className="border-2 border-green-600 text-green-600 rounded p-2 absolute right-4 top-2 u-semi hover:cursor-pointer">
                <p className="text-xs">Arrivée</p>
            </div>
        </div>
    );

}