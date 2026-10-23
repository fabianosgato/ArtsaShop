import {createRoot} from 'react-dom/client';
import ReviewBlock from "./components/reviews/Review.jsx";

const element = document.getElementById('reviews-list');

const root = createRoot(element);

root.render(<ReviewBlock />);
