export default function TrajetsAVenir() {


    const trajetRempli = false;

    return (
        <div className="flex flex-col gap-5 items-center justify-center bg-white px-10 shadow-box py-5 relative">
            <h2 className="u-semi text-xl underline"> Trajet à venir</h2>
            {trajetRempli ? (
                <>
                    <div className="bg-slate-200 px-3 py-2">
                        <p className="text-xs u-r">Trajet du 27/06 à 11H35 : Lyon - Berlin</p>
                    </div>
                    <div className="flex gap-3"> 
                        <div className="px-10 py-2 bg-redFull rounded text-white u-semi">
                            <p>Détails</p>
                        </div>
                        <div className="px-10 py-2 border-2 rounded border-redFull text-redFull u-semi">
                            <p>Modifier</p>
                        </div>
                    </div>
                </>
            ) : (
                <>
                    <div className="bg-slate-200 px-3 py-2">
                        <p className="text-xs u-r">Aucun trajet n’a été renseignée</p>
                    </div>
                    <div className="px-10 py-2 bg-redFull rounded text-white u-semi">
                        <p>Ajouter un trajet</p>
                    </div>
                </>
                
            )}
            
            <div className="border-2 border-green-600 text-green-600 rounded p-2 absolute right-4 top-2 u-semi">
                <p className="text-xs">Arrivée</p>
            </div>
        </div>
    );

}