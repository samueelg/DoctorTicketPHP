import { BellIcon } from "@heroicons/react/24/outline";
import { Badge } from 'primereact/badge';
import Button from "../atoms/Button";

export function Notificacao(){
return (
    <div className="fixed top-4 right-4">
        <Button
            variant="none"
            buttonClassName="p-overlay-badge relative p-0"
            icon={<BellIcon className="h-8 w-8" />}
        >
            <Badge 
                className="!text-xs !min-w-5 !h-5 flex items-center justify-center"
                severity="danger"
                value="2" />
        </Button>
    </div>
);
}