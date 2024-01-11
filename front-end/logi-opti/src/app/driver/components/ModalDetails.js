export default function ModalDetails({openDetails, setOpenDetails}) {


    return (
        (openDetails &&
        <div className="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div className="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div className="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">

                <div className="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div className="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div className="sm:flex sm:items-start">
                        <div className="mt-3 sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 className="u-semi text-2xl leading-6 text-center text-gray-900" id="modal-title">Détails du trajet</h3>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Nom du chauffeur</label>
                           <input value={"BENALIA Mohamed"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                        </div>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Adresse de départ</label>
                           <input value={"39 rue Guy de maupassant, 69800"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1 " type="text" />
                        </div>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Adresse de la destination</label>
                           <input value={"45 rue Guy de maupassant, 69800"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Date de départ</label>
                                <input value={"23/20/22 11H35"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Date d'arrivée</label>
                                <input value={"23/20/22 11H55"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Type de véhicule</label>
                           <input value={"Renault Master"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Cout du péage</label>
                                <input value={"27.55 €"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Cout de l'usure</label>
                                <input value={"37.58 €"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Distance parcourue</label>
                                <input value={"5 km"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Durée du trajet</label>
                                <input value={"15 minutes"} disabled className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                    
                    </div>
                    </div>
                    </div>
                    <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button onClick={()=> setOpenDetails(false)} type="button" className="inline-flex w-full justify-center rounded-md bg-redFull px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-redFullClair sm:ml-3 sm:w-auto">Fermer</button>
                    </div>
                </div>
                </div>
            </div>
        </div>)
    );

}