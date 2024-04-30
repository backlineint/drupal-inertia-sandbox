import PropTypes from "prop-types";

export default function Example({ event }) {
  return (
    <div>
      <h1>Inertia template loaded</h1>
      <p>Title: {event.title} </p>
      <p>Description: {event.description} </p>
    </div>
  );
}

Example.propTypes = {
  event: PropTypes.shape({
    title: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
  }),
};
