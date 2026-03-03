FROM python:3.10-slim

# Set working directory
WORKDIR /app

# Install dependencies
COPY server/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Download NLTK data
RUN python -m nltk.downloader vader_lexicon

# Copy the server directory contents
COPY server/ /app/

# Expose the port (Hugging Face Spaces defaults to 7860)
ENV PORT=7860
EXPOSE 7860

# Run the Gunicorn server
CMD ["gunicorn", "wsgi:app", "--bind", "0.0.0.0:7860"]
